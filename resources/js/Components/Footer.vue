<template>
  <footer class="bg-gray-900 text-gray-300 text-sm pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- Sobre a Loja -->
      <div>
        <h4 class="text-white font-bold text-base mb-3">Sobre a Loja</h4>
        <p class="mb-2">Alma Minhota é uma loja online dedicada aos produtos regionais do Norte de Portugal. Valorizamos o comércio local, a qualidade e a tradição.</p>
        <p class="text-xs text-gray-400 mt-4">
          © {{ new Date().getFullYear() }} Alma Minhota, Lda. Todos os direitos reservados.
        </p>
      </div>

      <!-- Navegação -->
      <div>
        <h4 class="text-white font-bold text-base mb-3">Navegação</h4>
        <ul class="space-y-2">
          <li><a href="/" class="hover:text-white transition">Início</a></li>
          <li><a href="/shop" class="hover:text-white transition">Loja</a></li>
          <li><a href="/sobre" class="hover:text-white transition">Sobre Nós</a></li>
          <li><a href="/contacto" class="hover:text-white transition">Contacto</a></li>
        </ul>
      </div>

      <!-- Informações Legais -->
      <div>
        <h4 class="text-white font-bold text-base mb-3">Informações Legais</h4>
        <ul class="space-y-2">
          <li><a href="/termos-e-condicoes" class="hover:text-white transition">Termos & Condições</a></li>
          <li><a href="/politica-de-privacidade" class="hover:text-white transition">Política de Privacidade</a></li>
          <li><a href="/envios-e-devolucoes" class="hover:text-white transition">Envios & Devoluções</a></li>
          <li><a href="/faq" class="hover:text-white transition">Perguntas Frequentes</a></li>
        </ul>
      </div>

      <!-- Contactos -->
      <div>
        <h4 class="text-white font-bold text-base mb-3">Contactos</h4>
        <ul class="space-y-2 text-sm">
          <li><font-awesome-icon :icon="['fas', 'map-marker-alt']" class="mr-2" /> Rua dos Sabores, 123, Braga</li>
          <li><font-awesome-icon :icon="['fas', 'phone']" class="mr-2" /> +351 912 345 678</li>
          <li><font-awesome-icon :icon="['fas', 'envelope']" class="mr-2" /> apoio@almaminhota.pt</li>
          <li><font-awesome-icon :icon="['fas', 'id-card']" class="mr-2" /> NIF: 509 123 456</li>
        </ul>

        <!-- Redes sociais -->
        <div class="flex items-center gap-4 mt-4 text-lg">
          <a href="#" class="hover:text-white"><font-awesome-icon :icon="['fab', 'facebook-f']" /></a>
          <a href="#" class="hover:text-white"><font-awesome-icon :icon="['fab', 'instagram']" /></a>
          <a href="#" class="hover:text-white"><font-awesome-icon :icon="['fab', 'tiktok']" /></a>
        </div>
      </div>
    </div>

    <!-- Linha final -->
    <div class="mt-10 text-center text-gray-500 text-xs">
      Este site está em conformidade com o Decreto-Lei n.º 24/2014 e o RGPD (UE) 2016/679.
    </div>
  </footer>
</template>
