const colors = require("tailwindcss/colors");

module.exports = {
    content: ["./resources/js/**/*.html", "./resources/js/**/*.vue"],
    theme: {
        extend: {
            colors: {
                theme: {
                    50: "#f2f6fc",
                    100: "#e1eaf8",
                    200: "#c9dbf4",
                    300: "#a4c4ec",
                    400: "#79a4e1",
                    500: "#5985d8",
                    600: "#456acb",
                    700: "#3b58ba",
                    800: "#354998",
                    900: "#344684",
                    950: "#21294a",
                },
                danger: colors.red,
                secondary: "#fcad03",
            },
            fontFamily: {
                urbanist: ["Urbanist", "sans-serif"],
                dance: ["Dancing Script", "cursive"],
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio"),
    ],
};
