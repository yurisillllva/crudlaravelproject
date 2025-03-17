<template>
  <div class="container mt-4">
    <!-- Adicione o modal ao template -->
    <category-modal
      :show="showCreateModal"
      @close="showCreateModal = false"
      @save="handleSave"
      :category="selectedCategory"
      :parent-categories="parentCategories"
    />
    <!-- Botão para abrir o modal -->
    <button @click="openCreateModal" class="btn btn-primary">
      Nova Categoria
    </button>
    <hr />
    <h2 class="mb-4">Lista de Categorias</h2>

    <div class="mb-3">
      <input
        v-model="searchQuery"
        @input="fetchCategories(1)"
        type="text"
        class="form-control"
        placeholder="Buscar categorias..."
      />
    </div>

    <div v-if="filteredCategories.length === 0" class="alert alert-info">
      Nenhuma categoria encontrada
    </div>

    <ul v-else class="list-group">
      <category-item
        v-for="category in categories"
        :key="category.id"
        :category="category"
      />
    </ul>
    <PaginationCategory/>
  </div>
</template>

<script>
import CategoryItem from "./CategoryItem.vue";
import CategoryModal from "./CategoryModal.vue";

export default {
  components: { CategoryItem, CategoryModal },
  data() {
    return {
      currentPage: 1,
      totalPages: 1,
      paginationLinks: [],
      showCreateModal: false,
      parentCategories: [],
      categories: [],
      searchQuery: "",
    };
  },
  computed: {
    filteredCategories() {
      return this.categories.filter((cat) => {
        return cat.name.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    },
  },
  async mounted() {
    await this.fetchCategories();
  },
  methods: {
    async fetchParentCategories() {
      const response = await this.$axios.get("/categories?parents_only=1");
      this.parentCategories = response.data.data;
    },
    openCreateModal() {
      this.selectedCategory = null;
      this.fetchParentCategories();
      this.showCreateModal = true;
    },
    async fetchCategories(page = 1) {
      try {
        const response = await this.$axios.get('/categories', {
          params: {
            page: page,
            search: this.searchQuery
          }
        });
        
        this.categories = response.data.data;
        this.currentPage = response.data.current_page;
        this.totalPages = response.data.last_page;
        this.paginationLinks = response.data.links;
      } catch (error) {
        console.error('Erro:', error);
      }
    },
    changePage(page) {
      if (page === '...') return;
      this.fetchCategories(page);
    }
  },
};
</script>