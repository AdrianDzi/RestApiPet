<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


</head>

<body>
    <div style="height: 300px; overflow-y:auto;">
        @if (isset($error))
            <div style="color: red; border: 1px solid red; padding: 10px; margin: 10px 0;">
                <strong>Błąd:</strong> {{ $error }}
            </div>
        @endif

        @if (isset($response))
            <div style="color: green; border: 1px solid green; padding: 10px; margin: 10px 0;">
                <strong>Wynik:</strong>
                {{-- @dd($response) --}}
                <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
    </div>

    <form action="{{ route('pet.uploadImage', ['petId' => 1]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Dodaj zdjęcie dla zwierzęcia</h3>

        <div>
            <label for="upload-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="petId" id="upload-pet-id" required>
        </div>

        <div>
            <label for="additionalMetadata">Dodatkowe dane:</label>
            <input type="text" name="additionalMetadata" id="additionalMetadata">
        </div>

        <div>
            <label for="file">Plik do przesłania:</label>
            <input type="file" name="file" id="file" required>
        </div>

        <button type="submit">Prześlij zdjęcie</button>
    </form>

    <form action="{{ route('pet.findByStatus') }}" method="GET">
        @csrf
        <h3>Znajdź zwierzęta według statusu</h3>

        <label for="status">Status:</label>
        <select name="status[]" id="status" multiple required>
            <option value="available">Dostępny</option>
            <option value="pending">Oczekujący</option>
            <option value="sold">Sprzedany</option>
        </select>

        <button type="submit">Szukaj</button>
    </form>

    <form action="{{ route('pet.updateNameAndStatus') }}" method="POST">
        @csrf
        <h3>Zaktualizuj nazwę i status zwierzęcia</h3>
        <div>
            <label for="update-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="petId" id="update-pet-id" required>
        </div>
        <div>
            <label for="update-pet-name">Nowa nazwa:</label>
            <input type="text" name="name" id="update-pet-name" required>
        </div>
        <div>
            <label for="update-pet-status">Nowy status:</label>
            <select name="status" id="update-pet-status" required>
                <option value="available">Dostępny</option>
                <option value="pending">Oczekujący</option>
                <option value="sold">Sprzedany</option>
            </select>
        </div>

        <button type="submit">Zaktualizuj</button>
    </form>

    <form action="{{ route('pet.get') }}" method="GET">
        <h3>Pobierz dane zwierzęcia</h3>
        <div>
            <label for="get-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="id" id="get-pet-id" required>
        </div>
        <button type="submit">Pobierz</button>
    </form>

    <form action="{{ route('pet.add') }}" method="POST">
        @csrf
        <h3>Dodaj nowe zwierzę</h3>

        <div>
            <label for="add-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="id" id="add-pet-id" required>
        </div>

        <div>
            <label for="category-id">ID Kategorii:</label>
            <input type="number" name="category_id" id="category-id" required>
        </div>
        <div>
            <label for="category-name">Nazwa Kategorii:</label>
            <input type="text" name="category_name" id="category-name" required>
        </div>

        <div>
            <label for="add-pet-name">Imię:</label>
            <input type="text" name="name" id="add-pet-name" required>
        </div>

        <div>
            <label for="photo-urls">Adresy zdjęć (oddzielone przecinkami):</label>
            <input type="text" name="photoUrls[]" id="photo-urls"
                placeholder="np. http://example.com/photo1,http://example.com/photo2">
        </div>

        <div>
            <label>Tagi (ID i nazwa):</label>
            <div>
                <input type="number" name="tag_ids[]" placeholder="ID Taga" required>
                <input type="text" name="tag_names[]" placeholder="Nazwa Taga" required>
            </div>
        </div>

        <div>
            <label for="add-pet-status">Status:</label>
            <select name="status" id="add-pet-status" required>
                <option value="available">Dostępny</option>
                <option value="pending">Oczekujący</option>
                <option value="sold">Sprzedany</option>
            </select>
        </div>

        <button type="submit">Dodaj</button>
    </form>

    <form action="{{ route('pet.update') }}" method="POST">
        @csrf
        <h3>Zaktualizuj dane zwierzęcia</h3>

        <div>
            <label for="update-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="id" id="update-pet-id" required>
        </div>

        <div>
            <label for="update-category-id">ID Kategorii:</label>
            <input type="number" name="category_id" id="update-category-id" required>
        </div>
        <div>
            <label for="update-category-name">Nazwa Kategorii:</label>
            <input type="text" name="category_name" id="update-category-name" required>
        </div>

        <div>
            <label for="update-pet-name">Imię:</label>
            <input type="text" name="name" id="update-pet-name" required>
        </div>

        <div>
            <label for="update-photo-urls">Adresy zdjęć (oddzielone przecinkami):</label>
            <input type="text" name="photoUrls[]" id="update-photo-urls"
                placeholder="np. http://example.com/photo1,http://example.com/photo2">
        </div>

        <div>
            <label>Tagi (ID i nazwa):</label>
            <div>
                <input type="number" name="tag_ids[]" placeholder="ID Taga" required>
                <input type="text" name="tag_names[]" placeholder="Nazwa Taga" required>
            </div>
            <div>
                <input type="number" name="tag_ids[]" placeholder="ID Taga">
                <input type="text" name="tag_names[]" placeholder="Nazwa Taga">
            </div>
            <div>
                <input type="number" name="tag_ids[]" placeholder="ID Taga">
                <input type="text" name="tag_names[]" placeholder="Nazwa Taga">
            </div>
        </div>

        <div>
            <label for="update-pet-status">Status:</label>
            <select name="status" id="update-pet-status" required>
                <option value="available">Dostępny</option>
                <option value="pending">Oczekujący</option>
                <option value="sold">Sprzedany</option>
            </select>
        </div>

        <button type="submit">Zaktualizuj</button>
    </form>
    <form action="{{ route('pet.delete') }}" method="POST">
        @csrf
        @method('DELETE')
        <h3>Usuń zwierzę</h3>
        <div>
            <label for="delete-pet-id">ID Zwierzęcia:</label>
            <input type="number" name="id" id="delete-pet-id" required>
        </div>
        <button type="submit">Usuń</button>
    </form>
</body>

</html>
