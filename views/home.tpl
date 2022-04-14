{extends file="_layouts/layout.tpl"}

{block name=css}
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
