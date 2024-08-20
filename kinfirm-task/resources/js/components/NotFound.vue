<template>
  <div class="not-found">
    <h1 class="error-code">404</h1>
    <p class="error-message">Page Not Found</p>
    <router-link to="/" class="home-link">Go to Home Page</router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style scoped>
.not-found {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: #f3f4f6;
  text-align: center;
}

.error-code {
  font-size: 6rem;
  font-weight: bold;
  color: #e11d48;
}

.error-message {
  font-size: 1.5rem;
  color: #333;
}

.home-link {
  margin-top: 1rem;
  font-size: 1rem;
  color: #25aae1;
  text-decoration: none;
}

.home-link:hover {
  text-decoration: underline;
}
</style>
