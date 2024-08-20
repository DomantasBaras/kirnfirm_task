import { createStore } from 'vuex';

export default createStore({
  state: {
    token: localStorage.getItem('token') || null,
  },
  getters: {
    isAuthenticated: state => !!state.token,
     getUserName: state => state.userName,
  },
  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
      localStorage.setItem('token', token); 
    },
    LOGOUT(state) {
      state.token = null;
      localStorage.removeItem('token'); 
      localStorage.removeItem('userName');
    },
    SET_USERNAME(state, username) {
      state.username = username;
      localStorage.setItem('username', username); 
    },
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        const response = await axios.post('/api/login', credentials);
        const { token, user } = response.data;

        localStorage.setItem('token', token);
        localStorage.setItem('userName', user.name);
        localStorage.setItem('userEmail', user.email);

        commit('SET_TOKEN', {
          token,
          userName: user.name,
          userEmail: user.email,
        });
        commit('SET_USERNAME', user.name);

        // Redirect to ProductList
        this.$router.push('/');
      } catch (error) {
        console.error('Error during login:', error);
      }
    },
    logout({ commit }) {
      localStorage.removeItem('token');
      localStorage.removeItem('userName');
      localStorage.removeItem('userEmail');

      commit('LOGOUT');

      // Redirect to login page
      this.$router.push('/login');
    },
  },
});
