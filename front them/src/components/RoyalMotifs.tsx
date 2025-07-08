interface RoyalMotifProps {
  className?: string;
  size?: number;
}

export function FleurDeLis({ className = "", size = 24 }: RoyalMotifProps) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      className={className}
    >
      <path
        d="M12 2C11.2 2 10.5 2.3 10 2.8C9.5 2.3 8.8 2 8 2C6.9 2 6 2.9 6 4C6 5.1 6.9 6 8 6C8.3 6 8.6 5.9 8.9 5.8C9.2 6.5 9.6 7.1 10.1 7.6C10.3 7.8 10.5 8 10.7 8.2C10.9 8.4 11.1 8.6 11.3 8.8C11.5 9 11.7 9.2 11.9 9.4C12.1 9.6 12.3 9.8 12.5 10C12.7 10.2 12.9 10.4 13.1 10.6C13.3 10.8 13.5 11 13.7 11.2C13.9 11.4 14.1 11.6 14.3 11.8C14.5 12 14.7 12.2 14.9 12.4C15.1 12.6 15.3 12.8 15.5 13C15.7 13.2 15.9 13.4 16.1 13.6C16.3 13.8 16.5 14 16.7 14.2C16.9 14.4 17.1 14.6 17.3 14.8C17.5 15 17.7 15.2 17.9 15.4C18.1 15.6 18.3 15.8 18.5 16C18.7 16.2 18.9 16.4 19.1 16.6C19.3 16.8 19.5 17 19.7 17.2C19.9 17.4 20.1 17.6 20.3 17.8C20.5 18 20.7 18.2 20.9 18.4C21.1 18.6 21.3 18.8 21.5 19C21.7 19.2 21.9 19.4 22.1 19.6C22.3 19.8 22.5 20 22.7 20.2C22.9 20.4 23.1 20.6 23.3 20.8C23.5 21 23.7 21.2 23.9 21.4C24.1 21.6 24.3 21.8 24.5 22"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
        fill="currentColor"
      />
      <path
        d="M12 3L10 8L12 12L14 8L12 3Z"
        fill="currentColor"
      />
      <path
        d="M7 10C7 8.9 7.9 8 9 8C10.1 8 11 8.9 11 10C11 11.1 10.1 12 9 12C7.9 12 7 11.1 7 10Z"
        fill="currentColor"
      />
      <path
        d="M13 10C13 8.9 13.9 8 15 8C16.1 8 17 8.9 17 10C17 11.1 16.1 12 15 12C13.9 12 13 11.1 13 10Z"
        fill="currentColor"
      />
      <path
        d="M10 16L12 20L14 16"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
        fill="currentColor"
      />
    </svg>
  );
}

export function RoyalCrown({ className = "", size = 24 }: RoyalMotifProps) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      className={className}
    >
      <path
        d="M5 16L3 8L6 10L9 4L12 8L15 4L18 10L21 8L19 16H5Z"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
        fill="currentColor"
      />
      <circle cx="9" cy="4" r="1" fill="currentColor" />
      <circle cx="12" cy="8" r="1" fill="currentColor" />
      <circle cx="15" cy="4" r="1" fill="currentColor" />
      <path
        d="M19 16H5V18C5 19.1 5.9 20 7 20H17C18.1 20 19 19.1 19 18V16Z"
        fill="currentColor"
      />
    </svg>
  );
}

export function RoyalScroll({ className = "", size = 24 }: RoyalMotifProps) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      className={className}
    >
      <path
        d="M3 6C3 4.9 3.9 4 5 4H19C20.1 4 21 4.9 21 6V18C21 19.1 20.1 20 19 20H5C3.9 20 3 19.1 3 18V6Z"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinecap="round"
        strokeLinejoin="round"
        fill="none"
      />
      <path
        d="M3 6C3 4.9 3.9 4 5 4C6.1 4 7 4.9 7 6C7 7.1 6.1 8 5 8C3.9 8 3 7.1 3 6Z"
        fill="currentColor"
      />
      <path
        d="M21 6C21 4.9 20.1 4 19 4C17.9 4 17 4.9 17 6C17 7.1 17.9 8 19 8C20.1 8 21 7.1 21 6Z"
        fill="currentColor"
      />
      <path
        d="M21 18C21 19.1 20.1 20 19 20C17.9 20 17 19.1 17 18C17 16.9 17.9 16 19 16C20.1 16 21 16.9 21 18Z"
        fill="currentColor"
      />
      <path
        d="M3 18C3 19.1 3.9 20 5 20C6.1 20 7 19.1 7 18C7 16.9 6.1 16 5 16C3.9 16 3 16.9 3 18Z"
        fill="currentColor"
      />
    </svg>
  );
}

export function RoyalOrnament({ className = "", size = 24 }: RoyalMotifProps) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      className={className}
    >
      <path
        d="M12 2L14 8L20 6L16 12L22 14L16 16L20 22L14 20L12 26L10 20L4 22L8 16L2 14L8 12L4 6L10 8L12 2Z"
        stroke="currentColor"
        strokeWidth="1"
        strokeLinecap="round"
        strokeLinejoin="round"
        fill="currentColor"
        opacity="0.8"
      />
      <circle cx="12" cy="12" r="3" fill="currentColor" />
    </svg>
  );
}

export function RoyalBorder({ className = "", width = 200, height = 2 }: { className?: string; width?: number; height?: number }) {
  return (
    <svg
      width={width}
      height={height * 10}
      viewBox={`0 0 ${width} ${height * 10}`}
      fill="none"
      className={className}
    >
      <pattern id="royal-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
        <path
          d="M10 2L12 6L18 5L15 10L20 12L15 14L18 19L12 18L10 22L8 18L2 19L5 14L0 12L5 10L2 5L8 6L10 2Z"
          fill="currentColor"
          opacity="0.3"
          transform="scale(0.5)"
        />
      </pattern>
      <rect width="100%" height="100%" fill="url(#royal-pattern)" />
      <path
        d={`M0 ${height * 5} Q${width / 4} ${height * 3} ${width / 2} ${height * 5} T${width} ${height * 5}`}
        stroke="currentColor"
        strokeWidth="2"
        fill="none"
      />
    </svg>
  );
}