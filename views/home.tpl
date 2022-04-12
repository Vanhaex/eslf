{extends file="_layouts/layout.tpl"}

{block name=css}
  <link href="/public/assets/style.css" rel="stylesheet" type="text/css" >
  <style media="screen">
    body {
      font-family: Inter,sans-serif;
      text-align: center;
    }
    .title {
      margin-top: 5rem;
    }
    .title h1{
      font-size: 4rem;
      margin-bottom: 0.75rem;
    }
    .credits {
      margin-bottom: 1.2rem;
      position: fixed;
      left: 0;
      width: 100%;
    }
    #github_logo {
      border-right: 1px solid lightgrey;
      padding-right: 10px;
      height: 4rem;
      width: 4rem;
    }
    #github_profile {
      padding-left: 6px;
      height: 4rem;
      width: 4rem;
      border-radius: 50%;
    }
  </style>
{/block}

{block name=js}{/block}

{block name=content}

<div class="title">
  <h1>ESLF</h1>
  <h2><i>Easy, Simple and Lightweight Framework</i></h2>

  {add_alert_message}

  <form>
    <input type="hidden" name="csrf_token" value="{$csrf_token}">


  </form>

</div>
<div class="credits">
  <a href="https://github.com/Vanhaex" ><img id="github_logo" src="/public/assets/images/github_logo.png" alt="github logo"></a>
  <a href="https://github.com/Vanhaex" ><img id="github_profile" src="/public/assets/images/github_profile.jpeg" alt="github profile pic"></a>
</div>

{/block}
