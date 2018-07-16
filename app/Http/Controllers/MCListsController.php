<?php

namespace App\Http\Controllers;

use App\Models\Mclist;
use Illuminate\Http\Request;

use App\MailChimp;

class MCListsController extends Controller
{

    protected $mc;

    public function __construct()
    {
        $this->mc = new MailChimp();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*get list of Mclists from MailChimp API*/
        $mclists = Mclist::getListsFromApi($this->mc);

        /*store in DB new items*/
        foreach($mclists as $mclist){
            $Mclist = new Mclist;

            /*remove unwanted fields*/
            $mclist = $this->prepareFieldsToSave($mclist);

            $Mclist->updateOrCreate(['id'=>$mclist['id']],
                $mclist
            );

        }
        return $mclists;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact.name' => 'required',
            'permission_reminder' => 'required',
            'campaign_defaults' => 'required',
            'email_type_option' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MCList  $mcList
     * @return \Illuminate\Http\Response
     */
    public function show(Mclist $Mclist)
    {
        /* if list exists, retrieve form DB, otherwise get form API and save to DB*/
        if(!$Mclist->exists) {

            $mcListId = request('mclist');
            $mcListApi = Mclist::getListFromApi($this->mc, $mcListId);

            #save to DB
            $Mclist->create(
                $mcListApi
            );

        }

        return $Mclist;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MCList  $mcList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MCList $mcList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MCList  $mcList
     * @return \Illuminate\Http\Response
     */
    public function destroy(MCList $mcList)
    {
        //
    }

    private function prepareFieldsToSave($mclist)
    {
        unset($mclist['_links']);

        return $mclist;
    }
}
