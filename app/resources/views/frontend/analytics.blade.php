@extends('frontend.includes.master')
@section('title', @$data['title'])
@section('content')
    <div class="container new-main-content">
        <div class="text-center">
            <h1 class="analytics">{{$data['title']}}</h1>
        </div>
        <form action="{{route('analytics')}}" method="get" onchange="submit()">
          <select class="form-select text-center form-control-lg mb-3" aria-label="" name="frequency">
            <option disabled>Select Frequency</option>
            <option value="daily" {{$data['frequency'] == "daily" ? 'selected':''}}>Daily</option>
            <option value="weekly" {{$data['frequency'] == "weekly" ? 'selected':''}}>Weekly</option>
            <option value="monthly" {{$data['frequency'] == "monthly" ? 'selected':''}}>Monthly</option>
            <option value="yearly" {{$data['frequency'] == "yearly" ? 'selected':''}}>Yearly</option>
          </select>
        </form>

        {{-- Vistor Data --}}
        <h3 class="text-center">Visitors</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Visitors</th>
                    <th>Sessions</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['visitors'] as $visitors)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $visitors['type'] }}</td>
                    <td>{{ $visitors['sessions'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>


        {{-- Most Vistied Pages Rank --}}
        <h3 class="text-center">Most Vistied Pages</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>URL</th>
                    <th>Page Title</th>
                    <th>Page Views</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['most_visited_pages'] as $mostVisited)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $mostVisited['url'] }}</td>
                    <td>{{ $mostVisited['pageTitle'] }}</td>
                    <td>{{ $mostVisited['pageViews'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>


        {{-- Page views --}}
        <h3 class="text-center">Page Views and Visitors</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>{{ _trans('common.Date') }}</th>
                    <th>Visitors</th>
                    <th>Page Title</th>
                    <th>Page Views</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['pageviews'] as $pageviews)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $pageviews['date'] }}</td>
                    <td>{{ $pageviews['visitors'] }}</td>
                    <td>{{ $pageviews['pageTitle'] }}</td>
                    <td>{{ $pageviews['pageViews'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>


        {{-- Refferers --}}
        <h3 class="text-center">Refferers</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>URL</th>
                    <th>Page Views</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['refferers'] as $refferers)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $refferers['url'] }}</td>
                    <td>{{ $refferers['pageViews'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>

        {{-- Country wise Data --}}
        <h3 class="text-center">Country</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-dark table-striped">
                <thead class="">
                  <tr>
                    <th>#</th>
                    <th>Country</th>
                    <th>Sessions</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['country'] as $country)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $country['country'] }}</td>
                    <td>{{ $country['sessions'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>

        {{-- Browser wise Data --}}
        <h3 class="text-center">Browsers</h3>
        <div class="container d-flex justify-align-around mb-5">
            <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Browsers</th>
                    <th>Sessions</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                  @foreach ($data['topbrowsers'] as $topbrowsers)
                  <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $topbrowsers['browser'] }}</td>
                    <td>{{ $topbrowsers['sessions'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('public/frontend/js/analytics.js') }}"></script> 
@endsection