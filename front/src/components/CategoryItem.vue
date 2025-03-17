<template>
  <li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <button 
          v-if="category.children && category.children.length > 0"
          @click="isExpanded = !isExpanded"
          class="btn btn-sm mr-2"
        >
          <i :class="isExpanded ? 'bi bi-dash-square' : 'bi bi-plus-square'"></i>
        </button>
        <span class="fw-bold">{{ category.name }}</span>
        <small v-if="category.description" class="text-muted d-block">
          {{ category.description }}
        </small>
      </div>
      <div>
        <button 
          @click="$emit('edit', category)"
          class="btn btn-sm btn-outline-primary mr-2"
        >
          <i class="bi bi-pencil-square"></i>
        </button>
        <button 
          @click="$emit('delete', category.id)"
          class="btn btn-sm btn-outline-danger"
        >
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </div>

    <ul v-if="isExpanded && category.children" class="list-group mt-2 ml-4">
      <category-item
        v-for="child in category.children"
        :key="child.id"
        :category="child"
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
      />
    </ul>
  </li>
</template>

<script>
export default {
  props: ['category'],
  data() {
    return {
      isExpanded: false
    }
  }
}
</script>

<style scoped>
/* .list-group-item {
  transition: all 0.3s ease;
}

.list-group-item:hover {
  background-color: #f8f9fa;
} */
</style>