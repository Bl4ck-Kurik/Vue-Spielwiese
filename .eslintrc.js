const { warn } = require("vue");

module.exports = {
    env: {
      node: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended"],
    rules: {
      /* eslint-disable */
      "vue/no-unused-components":"warn",
      "vue/multi-word-component-names":"warn",
      "vue/no-side-effects-in-computed-properties":"warn",
      "vue/no-mutating-props":"warn",
    },
  };
  