<!-- ChildComponent.vue -->
<template>
  <div>
    <div class="container">
      <div class="row">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <Link class="nav-link active" aria-current="page" href="/">Home</Link>
                </li>
                <li class="nav-item">
                  <Link href="/input-field" class="nav-link">Inputs</Link>
                </li>
                <li class="nav-item">
                  <Link href="/form-builder" class="nav-link">Form Builder</Link>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
      <div class="row">
        <slot name="main_content"></slot>
      </div>
    </div>
  </div>

</template>

<script>
import { Link } from '@inertiajs/vue3'
export default {
  name: 'AppLayout',
  components: {
    Link
  }
};
</script>

<style scoped>
li {
    list-style: none;
    margin: 5px;
    padding: 0;
    background: none;
    border: none;
    cursor: move;
}
nav {
  background-color: #152021;
}
</style>