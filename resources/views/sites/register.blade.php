@extends('layouts.frontend')

@section('content')
    <section class="banner-area relative about-banner" id="home">	
        <div class="overlay overlay-bg"></div>
        <div class="container">				
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        Pendaftaran				
                    </h1>	
                    <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="about.html"> Pendaftaran</a></p>
                </div>	
            </div>
        </div>
    </section>

    <section class="search-course-area relative" style="background: unset;">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-3 col-md-6 search-course-left">
                    <h1>
                        Pendafataran Online <br>
                        Bergabung bersama kami
                    </h1>
                    <p>
                        Kurikulum yang update dengan kebutuhan pasar, kami menjamin lulusan anda mudah terserap di dunia kerja.
                    </p>
                </div>
                <div class="col-lg-9 col-md-6 search-course-right section-gap">
                    {!! Form::open(['url' => '/postregister', 'class' => 'form-wrap']) !!}
                        <h4 class="pb-20 text-center mb-30">Formulir Pendaftaran</h4>	
                        {!! Form::text('nama_depan', '', ['class' => 'form-control', 'placeholder' => 'Nama Depan']) !!}	
                        {!! Form::text('nama_belakang', '', ['class' => 'form-control', 'placeholder' => 'Nama Belakang']) !!}	
                        {!! Form::text('agama', '', ['class' => 'form-control', 'placeholder' => 'Agama']) !!}	
                        {!! Form::textarea('alamat', '', ['class' => 'form-control', 'placeholder' => 'Alamat']) !!}
                        <div class="form-select" id="service-select">	
                            {!! Form::select('jenis_kelamin', ['' => 'Pilih Jenis Kelamin','L' => 'Laki-Laki', 'P' => 'Perempuan']); !!}
                        </div>		
                        
                        {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}

                        <input type="submit" class="primary-btn text-uppercase text-center" value="Kirim">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>	
    </section>
@endsection