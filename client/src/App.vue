<!-- client/src/App.vue -->
<template>
  <div id="app">
    <header>
    </header>
    <main>
      <AktuarskiRez />
      <AktuarskiIduci />
      <DoktorskiRez />
      <DoktorskiIduci />
      <PraktikumiRez />
      <PraktikumiIduci />
      <SnimanjaRez />
      <SnimanjaIduci />
    </main>
  </div>
</template>

<script>
import AktuarskiRez from './components/AktuarskiRez.vue';
import AktuarskiIduci from './components/AktuarskiIduci.vue';
import DoktorskiRez from './components/DoktorskiRez.vue';
import DoktorskiIduci from './components/DoktorskiIduci.vue';
import PraktikumiRez from './components/PraktikumiRez.vue';
import PraktikumiIduci from './components/PraktikumiIduci.vue';
import SnimanjaRez from './components/SnimanjaRez.vue';
import SnimanjaIduci from './components/SnimanjaIduci.vue';

export default {
  name: 'App',
  components: {
    AktuarskiRez,
    AktuarskiIduci,
    DoktorskiRez,
    DoktorskiIduci,
    PraktikumiRez,
    PraktikumiIduci,
    SnimanjaRez,
    SnimanjaIduci,
  },
};
</script>

<style>
#app {
  font-family: Arial, Helvetica, sans-serif;
}

p{
  color: #04AA6D;
}

header {
}

main {
  margin: 0 auto;
}
</style>
