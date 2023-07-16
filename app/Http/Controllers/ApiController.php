<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Entity;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category)
    {
        $category = $category;
        $client = new Client();

        try{

            $response = $client->get('https://api.publicapis.org/entries');
            $responseData = json_decode($response->getBody(), true);


            $entries = $responseData['entries'];

            $filteredEntries = array_filter($entries, function ($entry) use ($category) {
                return $entry['Category'] === $category;
            });

            $result = [];

            foreach($filteredEntries as $entry){
                //TODO! Buscar si existe la entidad
                $entity = Entity::where('api', $entry['API'])->first();
                //TODO! Buscar la categoria
                $category = Category::where('category', $entry['Category'])->first();

                //TODO! Si no existe, crearla
                if(!$entity){
                    $entity = new Entity();
                    $entity->api = $entry['API'];
                    $entity->description = $entry['Description'];
                    $entity->link = $entry['Link'];
                    $entity->category_id = $category->id;
                    $entity->save();
                }
                //TODO Mostrar resultados
                $result[] = [
                    'api' => $entry['API'],
                    'description' => $entry['Description'],
                    'link' => $entry['Link'],
                    'category' => [
                        'id' => $category->id,
                        'category' => $category->category
                    ]
                ];



            }
            $finalResponse = [
                'success' => true,
                'data' => $result
            ];
            return response()->json($finalResponse);

        }catch(RequestException $e){
            return response()->json([
                'error' => 'There was an error trying to get the data from the API'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
