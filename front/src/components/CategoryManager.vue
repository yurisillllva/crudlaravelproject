<template>
  <div class="container mt-4">
    <!-- Adicione o modal ao template -->
    <category-modal
      :show="showCreateModal"
      @close="showCreateModal = false"
      @saved="handleSaved"
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
        @edit="handleEdit" 
        @delete="handleDelete"
      />
    </ul>
    <PaginationCategory
      :pagination-links="paginationLinks"
      @page-changed="fetchCategories"
    />
  </div>
</template>

<script>
import CategoryItem from "./CategoryItem.vue";
import CategoryModal from "./CategoryModal.vue";
import PaginationCategory from './PaginationCategory.vue';

export default {
  components: { CategoryItem, CategoryModal, PaginationCategory },
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
    async handleEdit(category) {
      this.selectedCategory = category;
      await this.fetchParentCategories();
      this.showCreateModal = true;
    },
    async handleDelete(categoryId) {
      if (confirm('Tem certeza que deseja excluir esta categoria?')) {
        try {
          await this.$axios.delete(`/categories/${categoryId}`);
          this.fetchCategories(this.currentPage);
        } catch (error) {
          alert('Erro ao excluir categoria');
        }
      }
    },
     handleSaved() {
      this.fetchCategories(this.currentPage); // Recarrega os dados
      this.selectedCategory = null; // Limpa seleção
    },
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
            search: this.searchQuery,
            sort_by: '-created_at'
          }
        });
        
        this.categories = response.data.data;
        this.currentPage = response.data.meta.current_page;
        this.totalPages = response.data.meta.last_page;
        this.paginationLinks = response.data.meta.links;
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