<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Service\UserService;

/**
 *@OA\Info(
 *      version="1.0.0",
 *      title="Test API",
 *      description="test des API de Mr Kamela"
 * ),
 */

class UserController extends Controller 
{

  public function __construct(private UserService $UserService)
  {
  }

/**
* @OA\Get(
* path="/api/users",
* summary="liste utilisateurs",
* tags={"Users"},
* @OA\Parameter(
*         name="search_query",
*         in="query",
*         description="Mot-clé de recherche pour filtrer les utilisateurs",
*         @OA\Schema(type="string")
*     ),
* @OA\Response(
* response=200,
* description="liste utilisateur",
* ),
*@OA\Response(
*         response=401,
*         description="Non  autorisé",
*     ),
*     @OA\Response(
*         response=404,
*         description="Liste des utilisateurs introuvable",
*     ),
* )
*/    

//   ok
public function index()
{ 
  if(empty($_GET)){ 
      $users = User::with('roles')->get();
      if ($users->isEmpty()) {
          return response()->json([
              'success' => false,
              'message' => 'Aucun user trouvé',
          ], 404);
      }
  }else{
      if(isset($_GET['search_query'])){
          $users = $this->UserService->search_user($_GET['search_query']);
      }else{
          return response()->json([
              'success' => false,
              'message' => "Veuillez fournir un paramètre 'search_query' (exemple : search_query=mon_mot_cle) pour lancer votre recherche."
          ], 404);
      }
  }

  $response = [
      'success' => true,
      'users' => $users,
  ];
  return response()->json($response, 200);
}


  /**
* @OA\Post(
*     path="/api/connexion",
*     summary="connexion de utilisateur",
*     tags={"Users"},
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(),
*         @OA\MediaType(
*             mediaType="multipart/form-data",
*             @OA\Schema(
*                 type="object",
*                 required={"email","password"},
*                 @OA\Property(property="email", type="string"),
*                 @OA\Property(property="password", type="password"),
 *             )
 *         )
 *     ),
 *@OA\Response(
*         response=200,
*         description="Connexion réussie",
*     ),
*     @OA\Response(
*         response=401,
*         description="Identifiants invalides",
*     ),
*     @OA\Response(
*         response=422,
*         description="données invalides",
*     ),
* )
 *    
 * )
 */

  public function connexion(Request $request)
  {
      $user_data = Validator::make($request->all(), [
          "email" => ["required", "email", "exists:users,email"],
          "password" => ["required", "string", "min:8", "max:32", "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"]
      ]);
  
      if ($user_data->fails()) {
          return response()->json([
              "errors" => $user_data->errors()
          ], 422);
      }
      $user = User::where('email', $request->input('email'))->first();
  
      if (!$user || !Hash::check($request->input('password'), $user->password)) {

          return response()->json([
              'success' => false,
              'message' => 'Identifiants invalides'
          ], 401);
      }
     $token = $user->createToken('auth_token')->plainTextToken;
      
      return response()->json([
          'success' => true,
          'message' => "connexion réussie",
          "user" => $user,
          "token" =>  $token
      ], 200);
  } 

  //   "password_user": "P@ssw0rd123",
// ok
/**
* @OA\Post(
*     path="/api/users",
*     summary="Créer un utilisateur",
*     tags={"Users"},
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(),
*         @OA\MediaType(
*             mediaType="multipart/form-data",
*             @OA\Schema(
*                 type="object",
*                 required={"nom","prenom","email","ville","password","id_role"},
*                 @OA\Property(property="nom", type="string"),
*                 @OA\Property(property="prenom", type="string"),
*                 @OA\Property(property="phone", type="string"),
*                 @OA\Property(property="email", type="string", format="email", example="user@example.com" ),
*                 @OA\Property(property="ville", type="string"),
*                 @OA\Property(property="password", type="password", example="P@ssw0rd123"),
*                 @OA\Property(property="id_role", type="integer")
 *             )
 *         )
 *     ),
 *@OA\Response(
*         response=200,
*         description="Enregistrement réussi",
*     ),
*     @OA\Response(
*         response=422,
*         description="données invalides",
*     ),
*     @OA\Response(
*         response=500,
*         description="Impossible de mettre à jour car ce utilisateur n 'existe pas",
*     ),
* )
 *    
 * )
 */
public function create(Request $request)
{
  $user_userdata = Validator::make($request->all(), [
      "nom" => ["string","required","min:2","max:255"],
      "prenom" => ["string","required","min:2","max:255"],
      "ville" => ["string","required","min:2","max:255"],
      "phone" => ["string","required","min:2","max:255"],
      "email" => ["required","email","unique:users,email"],
      "password" => ["required","string","min:8","max:32","regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"],
      "id_role" => ["required","exists:roles,id"] 
]); 
if($user_userdata->fails()){
  return response()->json([
    "error : " => $user_userdata->errors() 
  ],422);
}
try { 

  $user = User::create([
      "nom" => $request->input("nom"),
      "email" => $request->input("email"),
      "prenom" => $request->input("prenom"),
      "phone" => $request->input("phone"),
      "ville" => $request->input("ville"),
      "password" => bcrypt($request->input("password"))
  ]);
  $user_role = User_role::create([
      "id_user" => $user->id,
      "id_role" =>$request->input('id_role')
  ]);
  $response = [
      'success' => true,
      'message' => 'Enregistrement réussi',
      'user' => $user
  ];

  return response()->json($response, 201);  
} catch (\Exception $e) {
  $response = [
      'success' => false,
      'message' => 'Une erreur est survenue lors de l\'enregistrement',
      'error' => $e->getMessage()

  ];
  return response()->json($response, 500);  
}
}

 /**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="info user",
 *     description="entrer juste ID.",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Utilisateur   
 *trouvé"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User non  trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Utilisateur   
 *non trouvé")
 *         )
 *     )
 * )
 */
public function get_one_user($id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Utilisateur non trouvé',
        ], 404);
    } 
    $users = User::with('roles',)
    ->where('id',$user->id)
    ->get();
    $response = [
        'success' => true,
        'message' => 'Utilisateur trouvé',
        'user' => $users,
    ];
    return response()->json($response, 200);
}
  
  
/**
 * @OA\Put(
 *     path="/api/users/{id_user}",
 *     summary="Update  user",
 *     tags={"Users"},
 *     description="Updates  user.",
 *     @OA\Parameter(
 *         name="id_user",
 *         in="path",
 *         required=true,
 *         description="ID user",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="updated_by",
 *         in="query",
 *         required=true,
 *         description="ID du user qui update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="donnée User",
 *         @OA\JsonContent(
 *                @OA\Property(property="nom", type="string"),
*                 @OA\Property(property="email", type="string", format="email", example="user@example.com" ),
*                 @OA\Property(property="active",type = "boolean"),
*                 @OA\Property(property="phone", type="string", example="+ 237 670875526"),
*                 @OA\Property(property="prenom",type = "string"),
*                 @OA\Property(property="ville",type = "string"),  
 *         )),
 *     @OA\Response(
 *         response=200,
 *         description="Mise à jour réussie",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string",   
 *example="Mise à jour réussie"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success",   
 *type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Impossible   
 *de mettre à jour car ce utilisateur n\'existe pas")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="pas autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Vous   
 *n'êtes pas autorisé à modifier cet utilisateur")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string",   
 *example="Une erreur est survenue lors de la mise à jour"),
 *             @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
  public function update(Request $request,$id_user)
  {
    $updated_by = request()->query('updated_by');
    if(!isset($updated_by)){
        return response()->json([
            'success' => false,
            'message' => "Vous n'êtes pas autorisé à modifier cet utilisateur"
        ], 422);
    }
      try {
          $user = User::findOrFail($id_user);
          if(isset($request->nom)){
            $user->nom = $request->input('nom');
          }if(isset($request->phone)){
            $user->phone = $request->input('phone');
          }if(isset($request->active)){
            $user->active = $request->active;
          }if(isset($request->ville)){
            $user->ville = $request->ville;
          }if(isset($request->prenom)){
            $user->prenom = $request->prenom;
          }
          $user->updated_by = $updated_by;
          $user->save();
          return response()->json([
              'success' => true,
              'message' => 'Mise à jour réussie',
              'user' => $user
          ], 200);
      } catch (\Exception $e) {
          if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
              return response()->json([
                  'success' => false,
                  'message' => 'Impossible de mettre à jour car ce utilisateur n\'existe pas'
              ], 404);
          } else {
              return response()->json([
                  'success' => false,
                  'message' => 'Une erreur est survenue lors de la mise à jour',
                  'error' =>$e->getMessage()
              ], 500);
          }
      }
  }
  
  /**
 * @OA\Delete(
 *     path="/api/users/{id_user}",
 *     summary="supprimer un utilisateur",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id_user",
 *         in="path",
 *         required=true,
 *         description="ID of the user to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="user deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success",   
 *type="boolean", example=true),
 *             @OA\Property(property="message", type="string",   
 *example="Suppression réussie")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="user not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Impossible   
 *de supprimer car cette entreprise n'existe pas")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string",   
 *example="Une erreur est survenue lors de la suppression"),
 *             @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Suppression réussie'
        ], 200);
    } catch (\Exception $e) {
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer car cette entreprise n\'existe pas',
            ], 404);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
  
}

?>