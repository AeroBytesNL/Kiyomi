<div class="mt-5">
  <div class="sidebar-header">
    <div class="sidebar-title fw-bold">
      Het weer op de club
    </div>
  </div>

  <div class="mt-4 mb-3">
    @php
        $response = \Illuminate\Support\Facades\Http::get(
          'https://api.weatherapi.com/v1/current.json', [
                'key'  => env('WEATHER_API_KEY'),
                'q'    => 'Boekelo',
                'lang' => 'nl',
            ]);

        if (!$response->successful()) {
          echo '<p>Fout bij het ophalen van de gegevens</p>';
          return;
        }

        $weather = $response->json();

        $windDirectionDegrees = [
            'N'   => 0,
            'NNE' => 22.5,
            'NE'  => 45,
            'ENE' => 67.5,
            'E'   => 90,
            'ESE' => 112.5,
            'SE'  => 135,
            'SSE' => 157.5,
            'S'   => 180,
            'SSW' => 202.5,
            'SW'  => 225,
            'WSW' => 247.5,
            'W'   => 270,
            'WNW' => 292.5,
            'NW'  => 315,
            'NNW' => 337.5,
        ];
    @endphp

    <div class="row">
      <div class="col">
        <p>
          Locatie: {{ $weather['location']['name'] }}<br>
          Temperatuur: {{ $weather['current']['temp_c'] }}C<br>
          Wind: {{ $weather['current']['wind_kph'] }}km/u<br>
          Windstoten: {{ $weather['current']['gust_kph'] }}km/u<br>
          Windrichting: {{ $weather['current']['wind_dir'] }}<br>
        </p>
      </div>

      <div class="col d-flex justify-content-center ">
        <img src="{{ $weather['current']['condition']['icon'] }}" style="width: 90px; height: 90px">
      </div>
    </div>


    <div class="position-relative d-inline-block" style="height: 100px;">
      <img src="/app_media/field-top.png" class="img rounded" style="height: 100px;">

      <div class="position-absolute top-50 start-50 translate-middle">
        <x-heroicon-o-arrow-long-up
          id="wind-arrow"
          style="
            width: 46px;
            transform: rotate({{ $windDirectionDegrees[$weather['current']['wind_dir']] ?? 0 }}deg);
            color: white;
            "
        />
      </div>
    </div>
  </div>
</div>
