<?php

namespace App\Http\Controllers;

use App\MclistMember;
use App\Models\Mclist;
use Illuminate\Http\Request;

use App\MailChimp;
use Illuminate\Support\Facades\Validator;

class MCListsController extends Controller
{

    #MailChimp API variable
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
        $mclists = MCList::getMembersFromApi($this->mc);

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        #validate request data
        $validator = $this->validator($data);

        #if don't pass this validation, return error status code
        if ($validator->fails()) {
            $this->setStatusCode(422);

            return $this->respondWithError($validator->errors());
        }

        #add list to api, and store the response
        $apiData = Mclist::addListToApi($this->mc, $data);

        #create model instance
        $Mclist = new Mclist();

        #save to DB
        $Mclist->create(
            $apiData
        );

        #set response status code to 'created'
        $this->setStatusCode(201);

        return $this->respondWithSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MCList  $mcList
     * @return \App\Models\MCList
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, MCList $mcList)
    {
        $data = $request->all();

        #add list to api, and store the response
        $apiData = Mclist::updateListToApi($this->mc, $mcList->id, $data);

        #save to DB
        $mcList->update(
            $apiData
        );

        #set responce status code to 'created'
        $this->setStatusCode(201);

        return $this->respondWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MCList  $mcList
     * @return \Illuminate\Http\Response
     */
    public function destroy(MCList $mcList)
    {
        #delete through MailChimp API
        Mclist::deleteListToApi($this->mc, $mcList->id);

        #delete from DB
        $mcList->delete();
    }

    /**
     * Remove specified attributes from model
     *
     * @param $mclist
     * @return mixed
     */
    private function prepareFieldsToSave($mclist)
    {
        unset($mclist['_links']);

        return $mclist;
    }

    /**
     * Validate request data for Mclist
     *
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'contact.company' => 'required',
            'contact.address1' => 'required',
            'contact.city' => 'required',
            'contact.state' => 'required',
            'contact.zip' => 'required',
            'contact.country' => 'required',
            'permission_reminder' => 'required',
            'campaign_defaults.from_name' => 'required',
            'campaign_defaults.from_email' => 'required',
            'campaign_defaults.subject' => 'required',
            'campaign_defaults.language' => 'required',
            'email_type_option' => 'boolean|required'
        ]);
    }

}
