<template>
    <div>
      <ul>
        <li 
          v-for="(item, index) in items" 
          :key="item"
          draggable="true"
          @dragstart="onDragStart(index)"
          @dragover.prevent
          @dragenter="onDragEnter(index)"
          @dragend="onDragEnd"
        >
          {{ item }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        items: ['a', 'b', 'c', 'd', 'e', 'f'],
        dragIndex: null,
      };
    },
    methods: {
      onDragStart(index) {
        this.dragIndex = index;
      },
      onDragEnter(index) {
        if (index !== this.dragIndex) {
          const temp = this.items.splice(this.dragIndex, 1)[0];
          this.items.splice(index, 0, temp);
          this.dragIndex = index;
        }
      },
      onDragEnd() {
        this.dragIndex = null;
      },
    },
  };
  </script>
  
  <style>
  li {
    list-style: none;
    margin: 5px;
    padding: 10px;
    background: #eee;
    border: 1px solid #ccc;
    cursor: move;
  }
  </style>