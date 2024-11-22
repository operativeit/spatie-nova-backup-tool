<template>
  <button
    type="button"
    v-tooltip.click="__(name)"
    :aria-label="__(name)"
    :dusk="`condition-${name}-button`"
    class="inline-flex items-center justify-center h-9 min-w-9 text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500"
  >
    <span class="flex items-center gap-1">
      <span>
        <Icon :type="icon" :solid="solid" v-if="icon" />
      </span>
      <slot />
    </span>
  </button>
</template>
<script>
import { Localization } from 'laravel-nova';
import { Icon } from 'laravel-nova-ui';

export default {
  props: {
    name: String,
    icon: {
      type: String
    },
    solid: {
      type: Boolean,
      default: false
    }
  }
};
</script>
