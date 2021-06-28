<!DOCTYPE html>
<html dir="ltr">
  <head>
    <title>Hello world !</title>
  </head>
  <body>
    <div class="title">
      <h1>ESLF</h1>
      <h2><i>Easy, Simple and Lighweight Framework</i></h2>
    </div>
    <div class="text-presentation">
      <h4>Si vous voyez cette page, c'est bon !</h4>
      <h4>Vous pouvez désormais modifier cette page comme bon vous semble !</h4>
      <p>Bon, pas de bêtises par contre hein...</p>
    </div>
    <div class="credits">
      <a href="https://github.com/Vanhaex" ><img id="github_logo" src="/public/assets/images/github_logo.png" alt="github logo"></a>
      <a href="https://github.com/Vanhaex" ><img id="github_profile" src="/public/assets/images/github_profile.jpeg" alt="github profile pic"></a>
    </div>
  </body>
</html>

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

  .text-presentation {
    border: 1px solid #1e99ff;
    background-color: #1e99ff;
    color: #FFF;
    border-radius: 0.75rem;
    margin-left: 40rem;
    margin-right: 40rem;
    margin-top: 6rem;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3),0 4px 6px -2px rgba(0,0,0,0.05);
  }

  .credits {
    margin-bottom: 1.2rem;
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
  }

  #github_logo {
    border-right: 1px solid lightgrey;
    padding-right: 10px;
    height: 2rem;
    width: 2rem;
  }

  #github_profile {
    padding-left: 6px;
    height: 2rem;
    width: 2rem;
    border-radius: 50%;
  }
</style>
