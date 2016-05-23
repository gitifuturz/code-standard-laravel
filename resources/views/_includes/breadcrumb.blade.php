<!-- Breadcrumb -->
<ol class="breadcrumb">
    @foreach(@$breadcrumb as $label=>$link)
        <li><a href="{{ $link }}">{{ $label }}</a></li>
    @endforeach
</ol>
