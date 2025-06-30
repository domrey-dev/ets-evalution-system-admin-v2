import React from "react";

export function Button({ className = "", children, ...props }) {
  return (
    <button
      className={`bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg ${className}`}
      {...props}
    >
      {children}
    </button>
  );
} 