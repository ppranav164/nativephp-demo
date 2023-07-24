<div>
      
       <h1 class="text-2xl font-extrabold">Jobs ({{$total_jobs}}) </h1>

       <button wire:click="update()">Refresh</button>

        <div class="grid grid-cols-4 gap-2">
          @foreach ($jobs as $job)
          <div>
            <div class="rounded overflow-hidden shadow-lg" id="{{ $job['guid'] }}">
              <div class="px-4 py-4">
                <div class="font-bold text-xl mb-2"> {{ $job['title'] }} </div>
                <p class="text-gray-700 text-base">
                <small> Published Date: {{ $job['published_date'] }}</small>
                </p>
                <p class="text-gray-700 text-base">
                  By: {{ $job['creator'] }}
                </p>
                <p class="text-gray-700 text-base">
                  <a target="_blank" class="text-blue-700" href="{{ $job['link'] }}">{{ $job['link'] }}</a>
                </p>
              </div>
              <div class="px-6 pt-4 pb-2">
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"> {{ $job['category'] }}</span>
              </div>
            </div>
          </div>
        @endforeach
        </div>
</div>
