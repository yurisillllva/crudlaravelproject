<template>
  <div v-if="show" class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ category?.id ? 'Editar Categoria' : 'Nova Categoria' }}
          </h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nome</label>
            <input v-model="formData.name" type="text" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea v-model="formData.description" class="form-control"></textarea>
          </div>
          <div class="mb-3" v-if="!isChild">
            <label class="form-label">Categoria Pai</label>
            <select v-model="formData.parent_id" class="form-select">
              <option :value="null">Nenhuma (Categoria Principal)</option>
              <option 
                v-for="parent in parentCategories"
                :key="parent.id"
                :value="parent.id"
              >
                {{ parent.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">
            Cancelar
          </button>
          <button type="button" class="btn btn-primary" @click="handleSave">
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
    category: {
      type: Object,
      default: () => ({}) 
    },
    parentCategories: Array
  },
  data() {
    return {
      formData: {
        name: '',
        description: '',
        parent_id: null
      }
    }
  },
  watch: {
    category: {
      immediate: true,
      handler(newVal) {
        this.formData = newVal?.id 
          ? { ...newVal } 
          : { name: '', description: '', parent_id: null }
      }
    }
  },
  methods: {
    resetForm() {
      this.formData = {
        name: '',
        description: '',
        parent_id: null
      }
    },
    handleSave() {
      this.$emit('save', this.formData)
    }
  }
}
</script>

<style scoped>
.modal-backdrop {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>