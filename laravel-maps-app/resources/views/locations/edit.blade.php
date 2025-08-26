@extends('layouts.app')

@section('title', 'Editar ' . $location->name . ' - Laravel Maps App')

    @section('styles')
    <link rel="stylesheet" href="{{ asset('css/pirates-style.css') }}">



@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-edit me-2"></i>Editar Local</h1>
            <a href="{{ route('locations.show', $location->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-map me-2"></i>Atualizar Localização</h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px;"></div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle me-1"></i>
                    Clique no mapa para atualizar as coordenadas do local
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Informações</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Local *</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $location->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $location->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude *</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                       class="form-control @error('latitude') is-invalid @enderror"
                                       value="{{ old('latitude', $location->latitude) }}" required>
                                @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude *</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                       class="form-control @error('longitude') is-invalid @enderror"
                                       value="{{ old('longitude', $location->longitude) }}" required>
                                @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" name="address" id="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $location->address) }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select name="category" id="category"
                                class="form-select @error('category') is-invalid @enderror">
                            <option value="">Selecione uma categoria</option>
                            @foreach(['Restaurante','Hotel','Shopping','Parque','Museu','Teatro','Hospital','Escola','Outro'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $location->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Atualizar Local
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var lat = parseFloat('{{ $location->latitude }}');
    var lng = parseFloat('{{ $location->longitude }}');

    var map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);

    map.on('click', function(e) {
        var newLat = e.latlng.lat;
        var newLng = e.latlng.lng;
        document.getElementById('latitude').value = newLat.toFixed(8);
        document.getElementById('longitude').value = newLng.toFixed(8);

        marker.setLatLng([newLat, newLng])
              .bindPopup(`<div class="text-center">
                  <strong>Nova localização:</strong><br>
                  Lat: ${newLat.toFixed(8)}<br>
                  Lng: ${newLng.toFixed(8)}
              </div>`).openPopup();
    });
});
</script>
@endsection