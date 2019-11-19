<div class="filAriane table">
    @foreach($filAriane as $lien)
    @if(isset($lien['lien']))
        <a href="{{$lien['lien']}}">{{$lien['titre']}}</a>
    @else
        {{$lien['titre']}}
    @endif

    @if($lien['titre'] != $filAriane[count($filAriane)-1]['titre'])
        <span>//</span>
    @endif
@endforeach
</div>
<div class="filAriane mobile">
    <svg class="filArianeIcone">
        <use xlink:href="#arrowLeft" />
    </svg>
    <p class="filArianeTitre">
        @if($_GET['action'] == "catalogue")
            <a href="{{$filAriane[0]['lien']}}">{{$filAriane[0]['titre']}}</a>
        @else
            <a href="{{$filAriane[1]['lien']}}">{{$filAriane[1]['titre']}}</a>
        @endif
    </p>
</div>
