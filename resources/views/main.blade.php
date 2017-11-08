@extends('layouts.app')

@section('content')

    <div class="main">
        <div class="menu-element menu-category file-btn-search"></div>
        <div class="menu-element menu-left prev" page-value="1"></div>
        <div class="menu-element menu-instagram"  onclick="getInsta()"></div>
        <div class="menu-element menu-members" onclick="showMain('login')"></div>
        <div class="menu-element menu-right next" page-value="1"></div>
        <div class="menu-element menu-bitcoin" onclick="showMain('bitcoin')"></div>

        <div class="menu-center">
            <div id="menu-text" class="main-text" data-prev='0'>
                <h2>Welcome!</h2>
            </div>

            <div id="drop" class="drop-text" data-prev='0'>
                <h2>Drop me here!</h2>
            </div>

            <div id="cat-search" class="category-search" data-prev='0'>
                <h3>Category Search !</h3>
                <select name="searchCate" onchange="searchCate(this.value)">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value='{{ $category->name }}'>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="login" class="login-menu" data-prev='0'>
                <h3>Authorization</h3>
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
                <input type="submit" value="Login">
            </div>

            <div id="bitcoin" class="bitcoin-menu" data-prev='0'>
                <h2>Bitcoin Section</h2>
            </div>
        </div>
    </div><!-- END MAIN -->
    <div class="main-canvas">
        <div class="scale-line">
            <div class="scale-back">
                <div id="canvas-line" class="scale-line-front" ondragstart="return false;" >
                    <div id="canvas-scale" onmousedown="canvasScale(event, $(this))" class="scale-btn"></div>
                </div>
            </div>
        </div>
        <div class="canvas" ondragstart="return false;" onmousedown="hideLatest()"></div>
        <div class="canvas-btn">
            <div class="canvas-btn-home" onclick="canvasHide()" ></div>
            <div class="canvas-btn-scale"></div>
            <div class="canvas-btn-print" onclick="savePDF()"></div>
        </div>
    </div>
    <div class="panels">
        @foreach($images as $key => $image)
            <div id='img-{{ $image->id }}' class='panel pos{{ $key+1 }} canva-img'>
                <img onmousedown='panelImg(event, $(this))' src='upload/{{ $image->name }}' />
            </div>
        @endforeach
    </div>

@endsection