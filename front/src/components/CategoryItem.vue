<template>
  <li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <span class="fw-bold">{{ category.name }}</span>
        <p v-if="category.description" class="mb-0 text-muted">
          {{ category.description }}
        </p>
      </div>
      <div>
        <button 
          class="btn btn-sm btn-outline-secondary"
          @click="toggleChildren"
        >
          {{ showChildren ? '▲' : '▼' }}
        </button>
      </div>
    </div>

    <!-- Subcategorias -->
    <ul 
      v-if="showChildren && category.children.length > 0"
      class="list-group mt-2 ms-4"
    >
      <category-item
        v-for="child in category.children"
        :key="child.id"
        :category="child"
      />
    </ul>
  </li>
</template>

<script>
export default {
  name: 'CategoryItem',
  props: {
    category: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      showChildren: false
    }
  },
  methods: {
    toggleChildren() {
      this.showChildren = !this.showChildren;
    }
  }
}
</script>

<style scoped>
.list-group-item {
  transition: all 0.3s ease;
}

.list-group-item:hover {
  background-color: #f8f9fa;
}
</style>