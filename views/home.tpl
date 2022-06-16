{extends file="_layouts/layout.tpl"}

{block name=css}
{/block}

{block name=js}{/block}

{block name=content}

<div class="title">
  <h1>ESLF</h1>
  <h2><i>Easy, Simple and Lightweight Framework</i></h2>
</div>
<div class="credits">
  <a href="https://github.com/Vanhaex" ><img id="github_logo" src="/public/assets/images/github_logo.png" alt="github logo"></a>
  <table>
    <thead>
    <tr>
      <th>id</th>
      <th>nom</th>
    </tr>
    </thead>
    <tbody>
    {foreach $res as $response }
      <tr style="text-align: center" >
        <td>{$response->id}</td>
        <td>{$response->name}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
</div>

{/block}
