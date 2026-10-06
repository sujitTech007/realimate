@php
      $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
    {{ !empty($pageHeading) ? $pageHeading->contact_page_title : __('Team') }}
@endsection

@section('metaKeywords')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_keyword_contact }}
    @endif
@endsection

@section('metaDescription')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_description_contact }}
    @endif
@endsection

<style>
    body {
      margin: 0;
      font-family: "Inter", sans-serif;
      background: #fff;
    }

    .team-section {
      text-align: center;
      padding: 60px 20px;
      background-color: #fff;
    }

    .section-heading {
      font-family: "Poppins", sans-serif;
      font-size: 28px;
      font-weight: 600;
      color: #CDB085;
      margin-bottom: 10px;
    }

    .section-subtitle {
      font-size: 16px;
      font-weight: 500;
      color: #333;
      margin-bottom: 40px;
    }

    .team-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr); /* 2-2 cards ek row me */
      gap: 100px;
      max-width: 1000px;
      margin: 0 auto;
    }

.team-card {
  background-color: #f9f9f9;
  padding: 60px 20px 20px; /* top padding badha di taki image overlap sahi lage */
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative; /* 👈 important */
}

.team-image {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  /*border: 2px solid #CDB085;*/
  position: absolute;  /* 👈 overlap ke liye */
  top: -60px;          /* 👈 half bahar nikalne ke liye */
  left: 50%;
  transform: translateX(-50%);
}


    .team-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .team-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #222;
    }

    .team-role {
      font-size: 15px;
      font-weight: 700;
      color: #CDB085;
      margin-bottom: 12px;
    }

    .description {
      font-size: 14px;
      line-height: 1.6;
      color: #666;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
      .team-container {
        grid-template-columns: 1fr; /* Mobile pe ek ek card neeche */
      }
      .section-subtitle {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 70px !important;
}
    }
  </style>
  

@section('content')
    @includeIf('frontend.partials.breadcrumb', [
        'breadcrumb' => $bgImg->breadcrumb,
        'title' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Team'),
        'subtitle' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Team'),
    ])

    <!--====================================================-->
    <!--============== Start Contact Section ===============-->
    <!--====================================================-->
    
    
    <section id="team" class="team-section">
    <!--<h1 class="section-heading">Our Team</h1>-->
    <!--<p class="section-subtitle"><b>Meet the Leaders Who Shape Our Success</b></p>-->

    <div class="team-container mt-5">
      <div class="team-card">
        <img src="{{ asset('assets/images/team/team-hameer_Imdad.png')}}" alt="CEO" class="team-image">
        <h2 class="team-title">Hameer Imdad Unnar</h2>
        <p class="team-role">CEO</p>
        <p class="description">
          Hameer Imdad Unnar, CEO of Realimate, leverages her leadership, critical thinking, and real estate expertise to drive strategic growth with a focus on sustainable development.
        </p>
      </div>

      <div class="team-card">
        <img src="{{ asset('assets/images/team/team-Sheeraz_Ali.png')}}" alt="COO" class="team-image">
        <h2 class="team-title">Sheeraz Ali Mangi</h2>
        <p class="team-role">COO</p>
        <p class="description">
          Sheeraz Ali Mangi, COO of Realimate, brings expertise in real estate and commerce, improving operational efficiency and driving profitability through market insights and process optimization.
        </p>
      </div>

      <div class="team-card">
        <img src="{{ asset('assets/images/team/team-3rdperson.png')}}" alt="CMO" class="team-image">
        <h2 class="team-title">Faiza Zahid</h2>
        <p class="team-role">CMO</p>
        <p class="description">
          Faiza Zahid, Realimate's CMO, drives digital marketing, brand management, and customer retention strategies, ensuring exceptional growth in the competitive real estate industry.
        </p>
      </div>

      <div class="team-card">
        <img src="{{ asset('assets/images/team/team-4thperson.png')}}" alt="CBO" class="team-image">
        <h2 class="team-title">Habib Ur Rehman</h2>
        <p class="team-role">CBO</p>
        <p class="description">
          Habib Ur Rehman, CBO of Realimate, brings a decade of experience in real estate and infrastructure projects, forging strategic partnerships to expand into new markets.
        </p>
      </div>
    </div>
  </section>
    <!--============ End Contact Section =============-->
@endsection
