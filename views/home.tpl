{extends file="_layouts/layout.tpl"}

{block name=css}{/block}

{block name=js}{/block}

{block name=content}

<div class="flex">
  <div class="flex w-2/5 md:w-1/4 h-screen bg-white">
    <div class="mx-auto py-10">
      <h1 class="text-2xl font-bold mb-10 cursor-p duration-150">Fruitiers</h1>
      <ul>
        <li class="flex space-x-2 mt-10 cursor-pointer duration-150">
          <i class="fa fa-home" ></i>
          <span class="font-semibold">Accueil</span>
        </li>
        <li class="flex space-x-2 mt-10 cursor-pointer duration-150">
          <i class="" ></i>
          <span class="font-semibold">Liste des genres</span>
        </li>
        <li class="flex space-x-2 mt-10 cursor-pointer duration-150">
          <i class="" ></i>
          <span class="font-semibold">Rechercher une variété</span>
        </li>
        <li class="flex space-x-2 mt-10 cursor-pointer duration-150">
          <i class="" ></i>
          <span class="font-semibold">Profile</span>
        </li>
        <li class="flex space-x-2 mt-10 cursor-pointer duration-150">
          <i class="" ></i>
          <span class="font-semibold">Setting</span>
        </li>
        <button class="w-full mt-10 rounded-full py-1.5 text-white">Learn</button>
      </ul>
    </div>
  </div>
  <main class=" min-h-screen w-full">
    <nav class="flex justify-between px-10 bg-white py-6">
      <div class="flex items-center bg-gray-100 px-4 py-2 rounded-md space-x-3 w-96">
        <input type="text" placeholder="search" class="bg-gray-100 outline-none w-full" />
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <div class="flex items-center">
        <i class="fa fa-user" ></i>
        <p>Elon Musk</p>
      </div>
    </nav>
  </main>
</div>

{/block}