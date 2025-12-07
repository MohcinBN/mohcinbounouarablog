<template>
  <div class="rich-text-editor">
    <div class="editor-menu border rounded-t p-2 bg-gray-50 flex gap-2 flex-wrap">
      <button
        v-for="item in menuItems"
        :key="item.action"
        @click="item.action"
        :class="[
          'p-2 rounded hover:bg-gray-200',
          { 'bg-gray-200': item.isActive?.() }
        ]"
        type="button"
      >
        {{ item.icon }}
      </button>
      <input
        ref="imageInput"
        type="file"
        class="hidden"
        accept="image/*"
        @change="uploadImage"
      />
    </div>
    <div 
      class="border rounded-b p-4 min-h-[200px]"
      :class="{ 'border-red-500': error }"
    >
      <editor-content :editor="editor" />
    </div>
    <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import axios from 'axios'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  error: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])

const imageInput = ref(null)

const editor = useEditor({
  content: props.modelValue,
  extensions: [
    StarterKit,
    Image
  ],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  }
})

const menuItems = [
  {
    icon: 'B',
    action: () => editor.value?.chain().focus().toggleBold().run(),
    isActive: () => editor.value?.isActive('bold')
  },
  {
    icon: 'I',
    action: () => editor.value?.chain().focus().toggleItalic().run(),
    isActive: () => editor.value?.isActive('italic')
  },
  {
    icon: 'H1',
    action: () => editor.value?.chain().focus().toggleHeading({ level: 1 }).run(),
    isActive: () => editor.value?.isActive('heading', { level: 1 })
  },
  {
    icon: 'H2',
    action: () => editor.value?.chain().focus().toggleHeading({ level: 2 }).run(),
    isActive: () => editor.value?.isActive('heading', { level: 2 })
  },
  {
    icon: 'UL',
    action: () => editor.value?.chain().focus().toggleBulletList().run(),
    isActive: () => editor.value?.isActive('bulletList')
  },
  {
    icon: 'OL',
    action: () => editor.value?.chain().focus().toggleOrderedList().run(),
    isActive: () => editor.value?.isActive('orderedList')
  },
  {
    icon: 'IMG',
    action: () => imageInput.value?.click()
  }
]

const uploadImage = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  const formData = new FormData()
  formData.append('image', file)

  try {
    const response = await axios.post('/upload-image', formData)

    const { url } = response.data
    editor.value?.chain().focus().setImage({ src: url }).run()
  } catch (error) {
    console.error('Image upload failed:', error)
  }

  // Clear the input
  event.target.value = ''
}

watch(() => props.modelValue, (newValue) => {
  const editorContent = editor.value?.getHTML()
  if (newValue !== editorContent) {
    editor.value?.commands.setContent(newValue)
  }
})

onBeforeUnmount(() => {
  editor.value?.destroy()
})
</script>

<style>
.ProseMirror {
  outline: none;
}

.ProseMirror p.is-editor-empty:first-child::before {
  color: #adb5bd;
  content: attr(data-placeholder);
  float: left;
  height: 0;
  pointer-events: none;
}
</style>
