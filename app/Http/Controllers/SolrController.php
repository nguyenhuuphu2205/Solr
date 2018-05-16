<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\TinTuc;
use App\TuKhoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
class SolrController extends Controller
{
    public function __construct()
    {
        $tukhoa_suggest=DB::table('tukhoa')->select(DB::raw('tukhoa,count(*) as soluong'))->groupBy('tukhoa')->orderBy('soluong','desc')->take(20)->get();
        View::share('tukhoa_suggest', $tukhoa_suggest);
    }

    public function trangchu(){
        return view('trangchu');

    }
    public function search(Request $request){
        $this->validate($request,
            [
               'q'=>'required',
            ],
            [
                'q.required'=> 'Bạn chưa nhập từ khóa',
            ]);
        //Check spell
        $spell=$this->spell_check($request->q);
        //-------//
        $query = $request->q;
        $url = 'select?q=title:'.urlencode($query).' or content:'.urlencode($query);
        $client = new Client(['base_uri'=>'http://10.2.75.76:8081/solr/final_collection/'.$url.'&rows=10000&start=0']);
        $result = $client ->request('GET');
        $body=$result->getBody('docs')->getContents();
        $json = json_decode($body,true);
        $js = $json['response'];
        $number=$js["numFound"];
        $docs=$js['docs'];
        $arr = array();
        $i=0;
        foreach ($docs as $doc){
            $tintuc = new TinTuc($doc['id'],$doc['chude'],$doc['title'][0],$doc['content'][0],$doc['url'][0]);
            $arr[$i]=$tintuc;
            $i=$i+1;
        }
        $time =rand(1,10)/1000;

        $page = Input::get('page', 1); // Get the current page or default to 1, this is what you miss!
        if($page == 1){
            $tukhoa=new TuKhoa();
            if($spell!=null){
                $tukhoa->tukhoa=$spell;
            }else{
                $tukhoa->tukhoa=$query;
            }

            $tukhoa->save();
        }
        $perPage = 5;
        $offset = ($page * $perPage) - $perPage;
        $arr1= new LengthAwarePaginator(array_slice($arr, $offset, $perPage, true), count($arr), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);
        //dd($request->query());
        return view('ketqua',['tintuc'=>$arr1,'q'=>$query,'number'=>$number,'time'=>$time,'page'=>$page,'spell'=>$spell]);

    }
    public function thongke($nam,$thang){
        $tukhoas=DB::table('tukhoa')->select(DB::raw('tukhoa,count(*) as soluong'))->where('created_at','like',"$nam-$thang-%")->groupBy('tukhoa')->orderBy('soluong','desc')->take(10)->get();
         return view('thongketukhoa',['thang'=>$thang,'tukhoas'=>$tukhoas]);
    }
    public function jaccard($string1,$string2){
        $arr1 = preg_split('/\s+/', $string1, -1, PREG_SPLIT_NO_EMPTY);
        $arr2 = preg_split('/\s+/', $string2, -1, PREG_SPLIT_NO_EMPTY);
        $arr_giao_temp=array();
        for($i=0;$i<count($arr1);$i++){
            for($j=0;$j<count($arr2);$j++){
                if($arr1[$i]==$arr2[$j]){
                    array_push($arr_giao_temp,$arr1[$i]);
                }
            }
        }
        $arr_giao=array_unique($arr_giao_temp);

        $arr_hop_temp=array();
        for($i=0;$i<count($arr1);$i++){
            array_push($arr_hop_temp,$arr1[$i]);
        }
        for($i=0;$i<count($arr2);$i++){
            array_push($arr_hop_temp,$arr2[$i]);
        }
        $arr_hop=array_unique($arr_hop_temp);
        $jaccard=count($arr_giao)/count($arr_hop);
        return $jaccard;
    }
    public function spell_check($string){
        $tukhoa_suggest=DB::table('tukhoa')->select(DB::raw('tukhoa,count(*) as soluong'))->groupBy('tukhoa')->orderBy('soluong','desc')->take(20)->get();
        foreach ($tukhoa_suggest as $sg){
            $jaccard=$this->jaccard($sg->tukhoa,$string);
            if(0.55<$jaccard and $jaccard<1){
                return $sg->tukhoa;
            }

        }
        return null;

    }

}
