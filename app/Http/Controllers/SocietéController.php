<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\Societé;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SocietéController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Societé::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('viewAny');

        $Societés = Societé::all();
        return response()->json(['Societé' => $Societés]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Societé::class);

        $request->validate([
            'name' => 'required|string',
        ]);

        $Societé = Societé::create([
            'name' => $request->name,
        ]);

        return response()->json(['Societé' => $Societé], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Societé = Societé::find($id);
        if (!$Societé) {
            return response()->json(['message' => 'Societé not found'], 404);
        }
        return response()->json(['Societé' => $Societé]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Societé = Societé::find($id);
        if (!$Societé) {
            return response()->json(['message' => 'Societé not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
        ]);

        $Societé->name = $request->name;
        $Societé->save();

        return response()->json(['Societé' => $Societé]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Societé = Societé::find($id);
        if (!$Societé) {
            return response()->json(['message' => 'Societé not found'], 404);
        }
        $Societé->delete();
        return response()->json(['message' => 'Societé deleted successfully']);
    }




public function attachUserToSociete(Request $request)
{



    $validator = Validator::make($request->all(), [
        'societe_id' => 'required|exists:societés,id',
        'user_id' => 'required|exists:users,id'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }




    try {
        // Retrieve the User and Societe models based on the provided IDs
        $user = User::findOrFail($request->user_id);
        $societe = Societé::findOrFail($request->societe_id);

        // Attach the user to the company
        $societe->users()->syncWithoutDetaching($user);

        // Return a success response
        return response()->json(['message' => 'User attached to Societe successfully'], 200);
    } catch (\Exception $e) {
        // Handle any exceptions and return an error response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function searchBySociete(Request $request)
{
    // Get the search query from the request
    $searchQuery = $request->input('query');

    // Get the sorting criteria from the request
    $sortBy = $request->input('sortBy', 'name');

    // Define the default order direction
    $sortOrder = $request->input('sortOrder', 'asc');

    // Query Societés and users based on the search query
    $Societés = Societé::where('name', 'like', "%$searchQuery%")
                        ->orderBy($sortBy, $sortOrder)
                        ->get();

    return response()->json([
        'societes' => $Societés,

    ]);

}
public function inviteUser(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:invitations',
        'societe_id' => 'required|exists:societés,id',
    ]);

    try {
        // Génération d'un token pour l'invitation
        $token = Invitation::generateToken();

        // Création de l'invitation dans la base de données
        Invitation::create([
            'email' => $request->email,
            'societe_id' => $request->societe_id,
            'token' => $token,
        ]);
        // Enregistrement de l'action dans l'historique
        Historique::create([
            'user_id' => auth()->id(),
            'action' => 'Envoi d\'invitation',
        ]);


        // Envoyer l'email d'invitation à l'utilisateur

        // Répondre avec un message de succès
        return response()->json(['message' => 'Invitation sent successfully'], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, renvoyer une réponse d'erreur
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function cancelInvitation(Request $request)
{
    // Valider les données de la demande
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    // Vérifier s'il y a des erreurs de validation
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    try {
        // Construire la requête de suppression
        $query = Invitation::where('email', $request->email);

        // Vérifier si societe_id est présent dans la demande
        if ($request->has('societe_id')) {
            $query->where('societé_id', $request->societé_id);

        } else {
            // Sinon, rechercher les invitations avec societe_id NULL
            $query->whereNull('societe_id');
        }

        // Supprimer les invitations correspondant à l'email et à la société
        $query->delete();
        // Enregistrement de l'action dans l'historique
        Historique::create([
            'user_id' => auth()->id(),
            'action' => 'Annulation d\'invitation',
        ]);

        // Répondre avec un message de succès
        return response()->json(['message' => 'Invitation canceled successfully'], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, renvoyer une réponse d'erreur
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function validateInvitation($id)
{
    try {
        // Trouver l'invitation correspondante dans la base de données
        $invitation = Invitation::findOrFail($id);

        // Valider l'invitation
        $invitation->validateInvitation();
        // Enregistrement de l'action dans l'historique
        Historique::create([
            'user_id' => auth()->id(),
            'action' => 'Validation d\'invitation',
        ]);

        // Répondre avec un message de succès
        return response()->json(['message' => 'Invitation validated successfully'], 200);
    } catch (\Exception $e) {
        // En cas d'erreur, renvoyer une réponse d'erreur
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
