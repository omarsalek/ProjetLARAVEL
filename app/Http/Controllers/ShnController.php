<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ShnController extends Controller
{
    public function gererAnnonces()
    {
        $user = Auth::user();
        return view('gererAnnonces', compact('user'));
    }

    public function choixCreationAnnonces()
    {
        return view('choixCreationAnnonces');
    }
    public function creationAnnonceChaussures(){
        return view('creationAnnonceChaussures');

    }

    public function creationAnnonceVetements()
    {
        return view('creationAnnonceVetements');
    }

    public function enregistrerAnnonceVet(Request $request)
    {
        $user = Auth::user();
        try {

            $request->validate([
                'adresse' => 'required',
                'ville' => 'required',
                'dateAnnonce' => 'required',
                'imageAnnonce' =>'required',
                'titre'=>'required',
                'categorie'=>'required',
                'marque'=>'required',
                'taille'=>'required',
                'saison'=>'required',
                'etatVetChauss'=>'required',
                'description'=>'required',
                'couleur'=>'required'
            ]);

            $queryLieu = DB::table('lieu')->insert([
                'adresse' => $request->input('adresse'),
                'ville' => $request->input('ville')
            ]);
            $idLieu = DB::getPdo()->lastInsertId();;
            #ImagInsert
            $file = $request->file("imageAnnonce");
            $extention = $file -> getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $path = $request->file('imageAnnonce')->storeAs(
                'imageAnnonces',
                $filename, 'public');

            $queryAnnonce = DB::table('annonce')->insert([
                'date' => $request->input('dateAnnonce'),
                'type' => $request->input('vetements'),
                'id' => $user->id,
                'etatAnnonce' => 0,
                'photoAnnonce' => $filename ,
                'idLieu' => $idLieu,
            ]);
            $idAnnonce = DB::getPdo()->lastInsertId();;

            $queryPhotos = DB::table('photovideo')->insert([
                    'descriptionPhotVid' => $filename ]);
            $idPhoto = DB::getPdo()->lastInsertId();;
            $queryVoirPhoto = DB::table('voirphotovideo')->insert([
                'idAnnonce' => $idAnnonce,
                'idPhoto'=>$idPhoto
            ]);
            $queryTitre = DB::table('typevetementchaussure')->insert([
                'lbelleVetChaus' => $request->input('titre')
            ]);
            $idTypeVet = DB::getPdo()->lastInsertId();;
            $queryVetementsAnnonce= DB::table('vetementchaussure')->insert([
                'categorie' => $request->input('categorie'),
                'marque' => $request->input('marque'),
                'saison' => $request->input('saison'),
                'taille' => $request->input('taille'),
                'etatVetChaus' => $request->input('etatVetChauss'),
                'description' => $request->input('description'),
                'couleur' =>$request->input('couleur'),
                'idAnnonce'=>$idAnnonce,
                'idTypVet'=>$idTypeVet
            ]);
            $idVetement = DB::getPdo()->lastInsertId();;
            $queryUpdateAnnonce = DB::table('annonce')->where('idAnnonce',$idAnnonce)->update([
                'idVetement' => $idVetement
            ]);


            return redirect()->back()->with('success', 'votre annonce est enregistrée!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('danger', 'Erreur survenue !');
        }
    }
    public function enregistrerAnnonceChaus(Request $request){
        $user = Auth::user();
        try {

            $request->validate([
                'adresse' => 'required',
                'ville' => 'required',
                'dateAnnonce' => 'required',
                'imageAnnonce' =>'required',
                'titre'=>'required',
                'categorie'=>'required',
                'marque'=>'required',
                'taille'=>'required',
                'saison'=>'required',
                'etatVetChauss'=>'required',
                'description'=>'required',
                'couleur'=>'required'
            ]);

            $queryLieu = DB::table('lieu')->insert([
                'adresse' => $request->input('adresse'),
                'ville' => $request->input('ville')
            ]);
            $idLieu = DB::getPdo()->lastInsertId();;
            #ImagInsert
            $file = $request->file("imageAnnonce");
            $extention = $file -> getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $path = $request->file('imageAnnonce')->storeAs(
                'imageAnnonces',
                $filename, 'public');

            $queryAnnonce = DB::table('annonce')->insert([
                'date' => $request->input('dateAnnonce'),
                'type' => $request->input('chaussures'),
                'id' => $user->id,
                'etatAnnonce' => 0,
                'photoAnnonce' => $filename ,
                'idLieu' => $idLieu,
            ]);
            $idAnnonce = DB::getPdo()->lastInsertId();;

            $queryPhotos = DB::table('photovideo')->insert([
                'descriptionPhotVid' => $filename ]);
            $idPhoto = DB::getPdo()->lastInsertId();;
            $queryVoirPhoto = DB::table('voirphotovideo')->insert([
                'idAnnonce' => $idAnnonce,
                'idPhoto'=>$idPhoto
            ]);
            $queryTitre = DB::table('typevetementchaussure')->insert([
                'lbelleVetChaus' => $request->input('titre')
            ]);
            $idTypeVet = DB::getPdo()->lastInsertId();;
            $queryVetementsAnnonce= DB::table('vetementchaussure')->insert([
                'categorie' => $request->input('categorie'),
                'marque' => $request->input('marque'),
                'saison' => $request->input('saison'),
                'taille' => $request->input('taille'),
                'etatVetChaus' => $request->input('etatVetChauss'),
                'description' => $request->input('description'),
                'couleur' =>$request->input('couleur'),
                'idAnnonce'=>$idAnnonce,
                'idTypVet'=>$idTypeVet
            ]);
            $idchaussure = DB::getPdo()->lastInsertId();;
            $queryUpdateAnnonce = DB::table('annonce')->where('idAnnonce',$idAnnonce)->update([
                'idVetement' => $idchaussure
            ]);


            return redirect()->back()->with('success', 'votre annonce est enregistrée!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('danger', 'Erreur survenue !');
        }
    }

}
