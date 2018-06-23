<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Phone;

use Illuminate\Http\Request;

use Image;
use File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $contacts = Contact::all();
        
        return view('contacts.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $favorite = 'no';
        if($request->input('favorite'))
        {
            $favorite = 'yes';
        }

        $this->validate($request, [
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasFile('profile_image')) 
        {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            
            $image = $request->file('profile_image');
            $destinationPath = public_path('/uploads/profile_images');
            $imagePath = $destinationPath. "/".  $fileNameToStore;
            $image->move($destinationPath, $fileNameToStore);
        } else {
            $fileNameToStore = "noImage.png";
        }

        $contactInsert = Contact::create ([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'profile_image' => $fileNameToStore,
            'favorite' => $favorite
        ]);
       
        foreach ($request->get('number') as $key=>$number) {
            $phone = array(
                'number' => $request->input('number')[$key],
                'description' => $request->input('description')[$key],
                'contact_id' => $contactInsert->id
            );

            Phone::insert($phone);
        }

        if($contactInsert) {
            return redirect()->route('show', ['contact' => $contactInsert])
                                ->with('success', 'Contact added successfully.');
        }

        return back()->withInput()->with('errors', 'Something went wrong.');
    }

    /**
     * Display the specified resource.
    */
    public function show($id)
    {
        $contact = Contact::find($id);

        return view('contacts.show', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        $contact = Contact::find($id);

        return view('contacts.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, $id)
    {
        $favorite = 'no';
        if($request->input('favorite')) {
            $favorite = 'yes';
        }

        $this->validate($request, [
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasFile('profile_image')) 
        {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
    
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            
            $image = $request->file('profile_image');
            $destinationPath = public_path('/uploads/profile_images');
            $imagePath = $destinationPath. "/".  $fileNameToStore;
            $image->move($destinationPath, $fileNameToStore);
        } else {
            $fileNameToStore = Contact::select('profile_image')->where('id', $id)->value('profile_image');
        }

        $contactUpdate = Contact::where('id', $id)
                                    ->update([
                                        'first_name' => $request->input('first_name'),
                                        'last_name' => $request->input('last_name'),
                                        'email' => $request->input('email'),
                                        'profile_image' => $fileNameToStore,
                                        'favorite' => $favorite
                                    ]);

        foreach ($request->get('phone_id') as $key=>$value) {   
            $newNumbers[] = $request->input('phone_id')[$key];
        }

        $contact = Contact::find($id);
        
        //prolazimo kroz listu brojeva telefona za određenog kontakta
        foreach ($request->get('phone_id') as $key=>$value) {
            //ukoliko phone_id nije prazan, znači da se radi o broju koji je postojao
            if($request->input('phone_id')[$key] != '') {
                foreach($contact->phones as $phone) {
                    //ako stari phone_id i dalje postoji među novim brojevima, azuriramo ga
                    if(in_array($phone->id, $newNumbers)) {
                        Phone::where('id', $request->input('phone_id')[$key])
                            ->update([
                                'number' => $request->input('number')[$key],
                                'description' => $request->input('description')[$key],
                                'contact_id' => $id
                            ]);
                    } else {
                        //stari phone_id vise nije u listi kontakovih brojeva, potrebno ga je obrisati
                        $phone->delete();
                    } 
                }
            } else {
                //phone_id je prazan, dakle korisnik je unio skroz novi broj, potrebno ga je unijeti u bazu
                $phone = array(
                    'number' => $request->input('number')[$key],
                    'description' => $request->input('description')[$key],
                    'contact_id' => $id
                );
                Phone::insert($phone);
            }   
        }

        if($contactUpdate) {
            return redirect()->route('show', ['contact' => $id])
                            ->with('success', 'Contact updated successfully');
        }
        
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $contactDelete = Contact::find($id);

        if($contactDelete->profile_image != 'noImage.png') {
            //Delete image from storage / public folder
            $image_path = public_path().'/uploads/profile_images/'.$contactDelete->profile_image;
            unlink($image_path);
        }

        foreach($contactDelete->phones() as $phone){
            $phone->delete();
        }

        if($contactDelete->delete()) {
            return redirect()->route('index')
                             ->with('success', 'Contact deleted successfully!');
        }

        return back()->withInput()->with('error', 'Contact could not be deleted.');
    }

    /**
     * Display a listing of the favorite resource.
     */
    public function favorite() 
    {
        $contacts = Contact::where('favorite', 'yes')->get();
                                
        return view('contacts.favorite', ['contacts' => $contacts]);
    }

    /**
     * Ajax request to change the value of "Favorite"
     */
    public function changeFavorite(Request $request) 
    {
        $contact_id = $request['contact_id'];
        $favorite = $request['favorite'];

        $contact = Contact::where('id', $contact_id)
                            ->update(['favorite' => $favorite]);
        
        return back()->withInput();
    }
}
