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
        $query = $request->q;
        $url = 'select?q=title:'.urlencode($query).' or content:'.urlencode($query);
        $client = new Client(['base_uri'=>'http://10.2.75.76:8081/solr/main-collection/'.$url.'&rows=10000&start=0']);
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
            $tukhoa->tukhoa=$query;
            $tukhoa->save();
        }
        $perPage = 5;
        $offset = ($page * $perPage) - $perPage;
        $arr1= new LengthAwarePaginator(array_slice($arr, $offset, $perPage, true), count($arr), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);
        //dd($request->query());
        return view('ketqua',['tintuc'=>$arr1,'q'=>$query,'number'=>$number,'time'=>$time,'page'=>$page]);

    }
    public function thongke($nam,$thang){
        $tukhoas=DB::table('tukhoa')->select(DB::raw('tukhoa,count(*) as soluong'))->where('created_at','like',"$nam-$thang-%")->groupBy('tukhoa')->orderBy('soluong','desc')->take(10)->get();
         return view('thongketukhoa',['thang'=>$thang,'tukhoas'=>$tukhoas]);
    }
}
