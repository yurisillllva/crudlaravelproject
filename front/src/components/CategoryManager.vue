<template>
  <div class="container mt-4">
    <h2 class="mb-4">Lista de Categorias</h2>
    
    <div class="mb-3">
      <input 
        v-model="searchQuery"
        type="text"
        class="form-control"
        placeholder="Buscar categorias..."
      >
    </div>

    <div v-if="filteredCategories.length === 0" class="alert alert-info">
      Nenhuma categoria encontrada
    </div>

    <ul v-else class="list-group">
      <category-item
        v-for="category in filteredCategories"
        :key="category.id"
        :category="category"
      />
    </ul>
  </div>
</template>

<script>
import CategoryItem from './CategoryItem.vue';

export default {
  components: { CategoryItem },
  data() {
    return {
      categories: [],
      searchQuery: ''
    }
  },
  computed: {
    filteredCategories() {
      return this.categories.filter(cat => {
        return cat.name.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    }
  },
  async mounted() {
    await this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await this.$axios.get('/categories');
        this.categories = response.data.data;
        console.log('Categorias carregadas:', this.categories);
      } catch (error) {
        console.error('Erro ao buscar categorias:', error);
      }
    }
  }
}
</script>