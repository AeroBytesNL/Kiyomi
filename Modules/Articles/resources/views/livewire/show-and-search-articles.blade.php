<div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-white">Artikelen</h2>

    <a href="{{ route('articles.create') }}" class="btn text-white" style="background-image: linear-gradient(45deg, #874da2 0%, #c43a30 100%)">
      Nieuw artikel
    </a>
  </div>

  <!-- FILTERS -->
  <div class="row">
    <div class="col ml-2">
      <div class="float-start mb-4 ms-0 mt-2">
        <input wire:model.live="articleSearch" type="text" id="article_search" placeholder="#, author, title, slug" class="form-control rounded">
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-custom-dark user-list ml-2 mr-2">
      <thead>
      <tr>
        <th scope="col" class="text-white">#</th>
        <th scope="col" class="text-white">Titel</th>
        <th scope="col" class="text-white">Author</th>
        <th scope="col" class="text-white">Datum en tijd</th>
        <th scope="col" class="text-white">Gepubliceerd</th>
        <th scope="col" class="text-white">Categorieën</th>
        <th scope="col" class="text-white">Opties</th>
      </tr>
      </thead>

      <tbody>
      @foreach ($articles as $article)
        <tr>
          <th scope="row" class="text-white">{{ $article->id }}</th>
          <th scope="row" class="text-white">
            {{ Str::words(strip_tags($article->title), 4)  }}
          </th>
          <th scope="row" class="text-white">{{ $article->author->name }}</th>
          <th scope="row" class="text-white">
            {{ \Carbon\Carbon::parse($article->created_at)->format('d-m-Y H:i:s') }}
          </th>
          <th scope="row" class="text-white">{{ $article->published === true ? 'Ja' : 'Nee' }}</th>
          <th scope="row" class="text-white">
            @foreach($article->categories as $category)
              {{ $category->name }}<br>
            @endforeach
          </th>
          <td style="width: 20%;" class="text-center">
            <div style="display: flex;">
              <form action="{{ route('articles.edit', $article->id) }}" method="GET" style="margin-right: 10px;">
                @csrf
                <x-buttons.edit />
              </form>

              <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <x-buttons.delete tooltip="Weet je zeker dat het artikel '{{ $article->title }}' wilt verwijderen?" />
              </form>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>


  {!! $articles->links('pagination::bootstrap-5') !!}
</div>
