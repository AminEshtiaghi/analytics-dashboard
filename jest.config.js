module.exports = {
  preset: '@vue/cli-plugin-unit-jest/presets/no-babel',
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/assets/$1'
  },
  transform: {
    "\\.js$": "<rootDir>/node_modules/babel-jest",
    '^.+\\.ts?$': 'ts-jest',
  }
};
