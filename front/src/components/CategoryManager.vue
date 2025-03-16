<template>
  <div>
    <div class="mb-3">
      <input v-model="searchQuery" type="text" class="form-control" placeholder="Buscar categorias...">
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
    
    <button class="btn btn-primary mt-3" @click="showModal = true">Nova Categoria</button>
    
    <category-modal
      :show="showModal"
      @close="showModal = false"
      @save="handleSave"
      :category="selectedCategory"
    />
  </div>
</template>

<script>
// Implementar lógica de busca, métodos CRUD e comunicação com API
</script>