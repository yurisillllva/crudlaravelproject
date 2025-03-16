<template>
  <div>
    <div class="mb-3">
      <input
        v-model="searchQuery"
        type="text"
        class="form-control"
        placeholder="Buscar categorias..."
      />
    </div>

    <ul class="list-group">
      <category-item
        v-for="category in filteredCategories"
        :key="category.id"
        :category="category"
        @edit="handleEdit"
        @delete="handleDelete"
      />
    </ul>

    <button class="btn btn-primary mt-3" @click="showModal = true">
      Nova Categoria
    </button>

    <category-modal
      :show="showModal"
      @close="showModal = false"
      @save="handleSave"
      :category="selectedCategory"
    />
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      categories: [],
      searchQuery: "",
      showModal: false,
      selectedCategory: null,
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
    async fetchCategories() {
      try {
        const response = await axios.get(
          "http://localhost:8000/api/categories"
        );
        this.categories = response.data;
      } catch (error) {
        console.error("Erro ao buscar categorias:", error);
      }
    },
    async handleSave(categoryData) {
      try {
        if (categoryData.id) {
          await axios.put(
            `http://localhost:8000/api/categories/${categoryData.id}`,
            categoryData
          );
        } else {
          await axios.post(
            "http://localhost:8000/api/categories",
            categoryData
          );
        }
        await this.fetchCategories();
      } catch (error) {
        console.error("Erro ao salvar categoria:", error);
      }
    },
    async handleDelete(id) {
      try {
        await axios.delete(`http://localhost:8000/api/categories/${id}`);
        await this.fetchCategories();
      } catch (error) {
        console.error("Erro ao excluir categoria:", error);
      }
    },
  },
};
</script>