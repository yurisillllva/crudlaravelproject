<template>
  <li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <button @click="isExpanded = !isExpanded" class="btn btn-sm mr-2">
          {{ isExpanded ? '-' : '+' }}
        </button>
        {{ category.name }}
      </div>
      <div>
        <button @click="$emit('edit', category)" class="btn btn-sm btn-warning">Editar</button>
        <button @click="$emit('delete', category.id)" class="btn btn-sm btn-danger ml-2">Excluir</button>
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