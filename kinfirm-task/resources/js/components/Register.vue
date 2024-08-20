<template>
  <div class="auth-container">
    <div class="form-wrapper">
      <h1 class="text-center text-2xl font-bold mb-6">Register</h1>
      <form @submit.prevent="register" class="space-y-4">
        <div class="form-group">
          <input
            v-model="name"
            type="text"
            placeholder="Name"
            class="input-field"
            required
          />
        </div>
        <div class="form-group">
          <input
            v-model="email"
            type="email"
            placeholder="Email"
            class="input-field"
            required
          />
        </div>
        <div class="form-group">
          <input
            v-model="password"
            type="password"
            placeholder="Password"
            class="input-field"
            required
          />
        </div>
        <div class="form-group">
          <input
            v-model="passwordConfirmation"
            type="password"
            placeholder="Confirm Password"
            class="input-field"
            required
          />
        </div>
        <button type="submit" class="submit-button">Register</button>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
        <p class="login-link">
          Already have an account? <router-link to="/login" class="text-blue-500 hover:underline">Login here</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      passwordConfirmation: '',
      errorMessage: '',
    };
  },
  methods: {
    async register() {
      if (this.password !== this.passwordConfirmation) {
        this.errorMessage = 'Passwords do not match.';
        return;
      }
      
      try {
        const response = await axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation,
        });
        localStorage.setItem('token', response.data.token); 
        this.$router.push('/'); 
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errorMessage = error.response.data.errors.password.join(', ');
        } else {
          this.errorMessage = 'Registration failed, please try again.';
        }
      }
    }
  }
};
</script>

<style scoped>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f3f4f6;
}

.form-wrapper {
  max-width: 400px;
  width: 100%;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2rem;
  color: #333;
}

.form-group {
  margin-bottom: 1rem;
}

.input-field {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
  font-size: 1rem;
  transition: border-color 0.3s;
}

.input-field:focus {
  border-color: #4f46e5;
  outline: none;
}

.submit-button {
  width: 100%;
  background-color: #25aae1;
  color: #fff;
  border: none;
  padding: 0.75rem;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #1d8ecf;
}

.error-message {
  color: #e11d48;
  font-size: 0.875rem;
}

.login-link {
  text-align: center;
  margin-top: 1rem;
}

.login-link a {
  color: #25aae1;
  font-weight: bold;
}
</style>
