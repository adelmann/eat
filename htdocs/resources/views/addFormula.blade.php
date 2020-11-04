<div class="row">
    <div class="col-8">
        @isset($EditEntry)
            <form method="POST" action="{{ route('updateEntry') }}">
                <input type="hidden" name="entryId" value="{{$EditEntry->id}}" />
        @else
            <form method="POST" action="{{ route('addnewtime') }}">
        @endisset

            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="categories">Kategorie</label>
                        <select class="form-control" id="categories" name="category" required>
                            <option value="">Bitte wählen</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}"
                                    @isset($EditEntry)
                                        @if ($EditEntry->catid == $category->id)
                                            selected
                                        @endif
                                    @endisset
                                >
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="title">Titel <small class="text-muted">optional</small></label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            id="title"
                            aria-describedby="titleHelp"
                            @isset($EditEntry)
                                @if ($EditEntry->title != '')
                                value="{{$EditEntry->title}}"
                                @endif
                            @endisset
                        >
                        <small id="titleHelp" class="form-text text-muted">Sofern für die Tätigkeit relevant</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="usedTime">Getätigte Zeit - Stunden:Minuten</label>
                        <input
                            type="time"
                            @isset($EditEntry)
                                value="{!! \App\Http\Controllers\Controller::getTranslatedTime($EditEntry->usedtime) !!}"
                            @else
                                value="00:15"
                            @endisset
                            min="00:15"
                            max="24:00"
                            class="form-control"
                            id="usedTime"
                            name="usedTime"
                            aria-describedby="usedTimeHelp"
                            required
                        >
                        <small id="usedTimeHelp" class="form-text text-muted">Wieviel Zeit wurde aufgebracht. Bitte in Stunden und Minuten eingeben. (Minuten aufgerundet immer mindestens in 15 Minuten Stufen.)</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="usedDate">Datum der Tätigkeit <small class="text-muted">optional</small></label>
                        <input
                            type="date"
                            @isset($EditEntry)
                                value="{{ date('yy-m-d', strtotime($EditEntry->date)) }}"
                            @endisset
                            class="form-control"
                            id="usedDate"
                            name="usedDate"
                            aria-describedby="usedDateHelp"
                        >
                        <small id="usedDateHelp" class="form-text text-muted">Wann wurde die Tätigkeit durchgeführt? (Sofern unbekannt wird aktuelles Datum genutzt.)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="description">Beschreibung der Tätigkeit <small class="text-muted">optional</small></label>
                        <textarea class="form-control" id="description" name="description" aria-describedby="descriptionHelp">@isset($EditEntry){{$EditEntry->description }}@endisset</textarea>
                        <small id="descriptionHelp" class="form-text text-muted">Sofern relevant kann hier eine Beschreibung der Tätigkeit angegeben werden.</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </div>

        </form>

    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <b>Infos:</b>
            </div>
            <div class="card-body">
                <span class="text-info">Kurze Infos zu den auszuwählenden Kategorien.</span>
                <hr>
                @foreach ($Categories as $category)
                    <div>
                        <p><b>{{$category->name}}</b></p>
                        <p>{{$category->description}}</p>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
