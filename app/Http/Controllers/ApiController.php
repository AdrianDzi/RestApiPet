<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://petstore.swagger.io/v2/';
    }

    public function uploadPetImage(Request $request, $petId)
    {
        $url = $this->baseUrl . "pet/{$petId}/uploadImage";

        $data = [
            'additionalMetadata' => $request->input('additionalMetadata'),
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $response = Http::attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
                ->post($url, $data);

            if ($response->successful()) {
                return redirect()->back()->with('response', $response->json());
            }

            return redirect()->back()->with('error', $this->handleError($response));
        }

        return redirect()->back()->with('error', 'Plik jest wymagany.');
    }

    public function findPetsByStatus(Request $request)
    {
        $url = $this->baseUrl . 'pet/findByStatus';

        $statuses = $request->input('status', []);

        if (empty($statuses)) {
            return redirect()->back()->with('error', 'Musisz wybrać co najmniej jeden status.');
        }

        $queryParams = implode(',', $statuses);

        try {
            $response = Http::get($url, ['status' => $queryParams]);

            if ($response->successful()) {
                $data = $response->json();

                if (empty($data)) {
                    return redirect()->back()->with('response', 'Brak zwierząt dla wybranego statusu.');
                }

                return view('welcome', ['response' => $data]);
            }
            return redirect()->back()->with('error', $this->handleError($response));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }


    public function updatePetNameAndStatus(Request $request)
    {
        $petId = $request->input('petId');

        $url = $this->baseUrl . "pet/{$petId}";

        $data = [
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ];

        try {
            $response = Http::asForm()->post($url, $data);

            if ($response->successful()) {
                return redirect()->back()->with('response', $response->json());
            }

            return redirect()->back()->with('error', $this->handleError($response));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    public function getPet(Request $request)
    {
        $id = $request->query('id');
        $url = $this->baseUrl . "pet/{$id}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return view('welcome', ['response' => $response->json()]);
            }

            return view('welcome', ['error' => $this->handleError($response)]);
        } catch (\Exception $e) {
            return view('welcome', ['error' => 'Wystąpił błąd: ' . $e->getMessage()]);
        }
    }
    public function addPet(Request $request)
    {
        $url = $this->baseUrl . 'pet';

        $data = [
            "id" => $request->input('id'),
            "category" => [
                "id" => $request->input('category_id'),
                "name" => $request->input('category_name'),
            ],
            "name" => $request->input('name'),
            "photoUrls" => $request->input('photoUrls', []),
            "tags" => array_map(function ($id, $name) {
                return ["id" => $id, "name" => $name];
            }, $request->input('tag_ids', []), $request->input('tag_names', [])),
            "status" => $request->input('status'),
        ];

        try {
            $response = Http::post($url, $data);

            if ($response->successful()) {
                return redirect()->back()->with('response', $response->json());
            }

            return redirect()->back()->with('error', $this->handleError($response));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    public function updatePet(Request $request)
    {
        $url = $this->baseUrl . 'pet';

        $data = [
            "id" => $request->input('id'),
            "category" => [
                "id" => $request->input('category_id'),
                "name" => $request->input('category_name'),
            ],
            "name" => $request->input('name'),
            "photoUrls" => $request->input('photoUrls', []), // domyślnie pusta tablica
            "tags" => array_map(function ($id, $name) {
                return ["id" => $id, "name" => $name];
            }, $request->input('tag_ids', []), $request->input('tag_names', [])),
            "status" => $request->input('status'),
        ];

        try {
            $response = Http::put($url, $data);

            if ($response->successful()) {
                return redirect()->back()->with('response', $response->json());
            }

            return redirect()->back()->with('error', $this->handleError($response));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    public function deletePet(Request $request)
    {
        $id = $request->input('id');
        $url = $this->baseUrl . "pet/{$id}";

        try {
            $response = Http::delete($url);

            if ($response->successful()) {

                return redirect()->back()->with('response', 'Zwierzę zostało pomyślnie usunięte.');
            }

            if ($response->status() == 404) {
                return redirect()->back()->with('error', 'Zwierzę o podanym ID zostało już usunięte lub nie istnieje.');
            }

            return redirect()->back()->with('error', 'Wystąpił nieoczekiwany błąd. Status: ' . $response->status());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    private function handleError($response)
    {
        $status = $response->status();
        $body = $response->json();

        switch ($status) {
            case 400:
                return 'Żądanie jest nieprawidłowe: ' . ($body['message'] ?? 'Nieznany błąd');
            case 404:
                return 'Nie znaleziono zasobu. Sprawdź ID zwierzęcia.';
            case 500:
                return 'Błąd serwera. Spróbuj ponownie później.';
            default:
                return 'Wystąpił nieoczekiwany błąd: ' . $response->body();
        }
    }
}
