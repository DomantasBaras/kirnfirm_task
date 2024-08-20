<template>
  <div id="app">
    <header class="app-header">
      <div class="header-content">
        <h1 class="app-title">Product Management</h1>
        
        <!-- User Dropdown -->
        <div v-if="isLoggedIn" class="user-dropdown">
          <button @click="toggleDropdown" class="user-button">
            {{ userName }} &#x25BC;
          </button>
          <div v-if="dropdownOpen" class="dropdown-menu">
            <button @click="logout" class="dropdown-item">Logout</button>
          </div>
        </div>
      </div>
    </header>
    <router-view></router-view>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
export default {
    computed: {
    ...mapGetters(['isAuthenticated', 'getUserName']),
    isLoggedIn() {
      return this.isAuthenticated;
    },
    userName() {
      return this.getUserName;
    },
  },
  data() {
    return {
      dropdownOpen: false,
    };
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
    async logout() {
      try {
        await axios.post('/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        localStorage.removeItem('token');
        localStorage.removeItem('userName');
        this.$store.commit('LOGOUT');
        this.$router.push('/login');
      } catch (error) {
        console.error('Error logging out:', error);
      }
    },
  },
  mounted() {
    if (this.isLoggedIn) {
      axios.get('/api/user', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      })
      .then(response => {
          this.userName = response.data.name;

      })
      .catch(error => {
        console.error('Error fetching user details:', error);
      });
    }
  }
}
</script>

<style scoped>
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #25aae1;
  color: #ffffff;
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.header-content {
  display: flex;
  justify-content: space-between;
  width: 100%;
  align-items: center;
}

.app-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.user-dropdown {
  position: relative;
}

.user-button {
  background-color: transparent;
  color: white;
  border: none;
  font-size: 1rem;
  cursor: pointer;
  padding: 0.5rem;
}

.user-button:hover {
  color: #ccc;
}

.dropdown-menu {
  position: absolute;
  right: 0;
  top: 100%;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-top: 0.5rem;
  min-width: 150px;
  z-index: 1000;
}

.dropdown-item {
  padding: 10px;
  background-color: white;
  color: black;
  border: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  border-radius: 8px;
}

.dropdown-item:hover {
  background-color: #f3f4f6;
}
</style>
