const colors = {
  "grey-darkest": "#3d4852",
  "grey-darker": "#606f7b",
  "grey-dark": "#8795a1",
  grey: "#b8c2cc",
  "grey-light": "#dae1e7",
  "grey-lighter": "#f1f5f8",
  "grey-lightest": "#f8fafc",
  "grey-mid-light": "#f3f3f4",
  "white-lightest": "#f4f4f4",

  "red-darkest": "#3b0d0c",
  "red-darker": "#621b18",
  "red-dark": "#cc1f1a",
  "red-light": "#ef5753",
  "red-lighter": "#f9acaa",
  "red-lightest": "#fcebea",

  "orange-darkest": "#462a16",
  "orange-darker": "#613b1f",
  "orange-dark": "#de751f",
  "orange-light": "#faad63",
  "orange-lighter": "#fcd9b6",
  "orange-lightest": "#fff5eb",

  "yellow-darkest": "#453411",
  "yellow-darker": "#684f1d",
  "yellow-dark": "#f2d024",
  "yellow-light": "#fff382",
  "yellow-lighter": "#fff9c2",
  "yellow-lightest": "#fcfbeb",

  "green-darkest": "#0f2f21",
  "green-darker": "#1a4731",
  "green-dark": "#1f9d55",
  "green-light": "#51d88a",
  "green-lighter": "#a2f5bf",
  "green-lightest": "#e3fcec",

  "teal-darkest": "#0d3331",
  "teal-darker": "#20504f",
  "teal-dark": "#38a89d",
  "teal-light": "#64d5ca",
  "teal-lighter": "#a0f0ed",
  "teal-lightest": "#e8fffe",

  "blue-darkest": "#12283a",
  "blue-darker": "#1c3d5a",
  "blue-dark": "#2779bd",
  "blue-light": "#6cb2eb",
  "blue-lighter": "#bcdefa",
  "blue-lightest": "#eff8ff",

  "indigo-darkest": "#191e38",
  "indigo-darker": "#2f365f",
  "indigo-dark": "#5661b3",
  "indigo-light": "#7886d7",
  "indigo-lighter": "#b2b7ff",
  "indigo-lightest": "#e6e8ff",

  "purple-darkest": "#21183c",
  "purple-darker": "#382b5f",
  "purple-dark": "#794acf",
  "purple-light": "#a779e9",
  "purple-lighter": "#d6bbfc",
  "purple-lightest": "#f3ebff",

  "pink-darkest": "#451225",
  "pink-darker": "#6f213f",
  "pink-dark": "#eb5286",
  "pink-light": "#fa7ea8",
  "pink-lighter": "#ffbbca",
  "pink-lightest": "#ffebef",

  nav: "#3F495E",
  "side-nav": "#ECF0F1",
  "nav-item": "#626b7a",
  "light-border": "#dfe4e6",
  "white-medium": "#FAFAFA",
  "white-medium-dark": "#E5E9EB",
  "red-vibrant": "#e46050",
  "red-vibrant-dark": "#d64230",
  primary: "#51BE99",
  "primary-dark": "#0e5f43",
  warning: "#f4ab43",
  "warning-dark": "#c37c16",
  "black-dark": "#272634",
  "black-darkest": "#141418",
  info: "#52bcdc",
  "info-dark": "#2cadd4",
  success: "#72b159",
  "success-dark": "#5D9547",

  transparent: "transparent",

  black: "#000",
  white: "#fff",

  gray: {
    100: "#f7fafc",
    200: "#edf2f7",
    300: "#e2e8f0",
    400: "#cbd5e0",
    500: "#a0aec0",
    600: "#718096",
    700: "#4a5568",
    800: "#2d3748",
    900: "#1a202c",
  },
  red: {
    100: "#fff5f5",
    200: "#fed7d7",
    300: "#feb2b2",
    400: "#fc8181",
    500: "#f56565",
    600: "#e53e3e",
    700: "#c53030",
    800: "#9b2c2c",
    900: "#742a2a",
  },
  orange: {
    100: "#fffaf0",
    200: "#feebc8",
    300: "#fbd38d",
    400: "#f6ad55",
    500: "#ed8936",
    600: "#dd6b20",
    700: "#c05621",
    800: "#9c4221",
    900: "#7b341e",
  },
  yellow: {
    100: "#fffff0",
    200: "#fefcbf",
    300: "#faf089",
    400: "#f6e05e",
    500: "#ecc94b",
    600: "#d69e2e",
    700: "#b7791f",
    800: "#975a16",
    900: "#744210",
  },
  green: {
    100: "#f0fff4",
    200: "#c6f6d5",
    300: "#9ae6b4",
    400: "#68d391",
    500: "#48bb78",
    600: "#38a169",
    700: "#2f855a",
    800: "#276749",
    900: "#22543d",
  },
  teal: {
    100: "#e6fffa",
    200: "#b2f5ea",
    300: "#81e6d9",
    400: "#4fd1c5",
    500: "#38b2ac",
    600: "#319795",
    700: "#2c7a7b",
    800: "#285e61",
    900: "#234e52",
  },
  blue: {
    100: "#ebf8ff",
    200: "#bee3f8",
    300: "#90cdf4",
    400: "#63b3ed",
    500: "#4299e1",
    600: "#3182ce",
    700: "#2b6cb0",
    800: "#2c5282",
    900: "#2a4365",
  },
  indigo: {
    100: "#ebf4ff",
    200: "#c3dafe",
    300: "#a3bffa",
    400: "#7f9cf5",
    500: "#667eea",
    600: "#5a67d8",
    700: "#4c51bf",
    800: "#434190",
    900: "#3c366b",
  },
  purple: {
    100: "#faf5ff",
    200: "#e9d8fd",
    300: "#d6bcfa",
    400: "#b794f4",
    500: "#9f7aea",
    600: "#805ad5",
    700: "#6b46c1",
    800: "#553c9a",
    900: "#44337a",
  },
  pink: {
    100: "#fff5f7",
    200: "#fed7e2",
    300: "#fbb6ce",
    400: "#f687b3",
    500: "#ed64a6",
    600: "#d53f8c",
    700: "#b83280",
    800: "#97266d",
    900: "#702459",
  },
};

module.exports = {
  content: [
    "./public/**/*.{html,php,js}", // Adjust the path based on your project's structure
  ],
  theme: {
    extend: {
      colors: colors,
      spacing: {
        px: "1px",
        0: "0",
        1: "0.25rem",
        2: "0.5rem",
        3: "0.75rem",
        4: "1rem",
        5: "1.25rem",
        6: "1.5rem",
        8: "2rem",
        10: "2.5rem",
        12: "3rem",
        16: "4rem",
        20: "5rem",
        24: "6rem",
        32: "8rem",
        40: "10rem",
        48: "12rem",
        56: "14rem",
        64: "16rem",
      },
      margin: {
        auto: "auto",
        px: "1px",
        0: "0",
        1: "0.25rem",
        2: "0.5rem",
        3: "0.75rem",
        4: "1rem",
        5: "1.25rem",
        6: "1.5rem",
        8: "2rem",
        10: "2.5rem",
        12: "3rem",
        16: "4rem",
        20: "5rem",
        24: "6rem",
        32: "8rem",
        "-px": "-1px",
        "-1": "-0.25rem",
        "-2": "-0.5rem",
        "-3": "-0.75rem",
        "-4": "-1rem",
        "-5": "-1.25rem",
        "-6": "-1.5rem",
        "-8": "-2rem",
        "-10": "-2.5rem",
        "-12": "-3rem",
        "-16": "-4rem",
        "-20": "-5rem",
        "-24": "-6rem",
        "-32": "-8rem",
      },
    },
  },
  variants: {
    appearance: ["responsive"],
    zIndex: ["responsive"],
  },
  plugins: [require("tailwindcss-tables")()],
};
