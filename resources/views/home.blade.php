<x-app-layout>
    <div class="container mt-5">
    <h2 class="text-center mb-4">Recente Advertenties</h2>
    <div class="row">
        @foreach ($advertenties as $advertentie)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 mx-auto" style="max-width: 300px;">
                    <img src="{{ asset('storage/' . $advertentie->image_path) }}" alt="{{ $advertentie->title }}" class="card-img-top img-fluid" style="max-height: 150px; object-fit: cover;"> 
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $advertentie->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($advertentie->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">€{{ $advertentie->price }}</small>
                            <a href="{{ route('advertenties.show', $advertentie) }}" class="btn btn-primary">Bekijk</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
