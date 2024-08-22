import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './resources/views/components/**/*.blade.php',
        './resources/views/livewire/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
}
