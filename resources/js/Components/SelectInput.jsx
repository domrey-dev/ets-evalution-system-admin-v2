import { forwardRef, useRef } from "react";

export default forwardRef(function SelectInput(
  { className = "", children, ...props },
  ref
) {
  const input = ref ? ref : useRef();

  return (
    <div className="relative">
      <select
        {...props}
        className={
          "border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white pr-10 py-2.5 px-3 text-sm cursor-pointer hover:border-gray-400 transition-colors duration-200 " +
          "appearance-none -webkit-appearance-none -moz-appearance-none " +
          "[&::-ms-expand]:hidden " +
          className
        }
        ref={input}
        style={{
          backgroundImage: 'none',
          WebkitAppearance: 'none',
          MozAppearance: 'none',
          appearance: 'none'
        }}
      >
        {children}
      </select>
      {/* Custom dropdown arrow */}
      <div className="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg
          className="h-4 w-4 text-gray-400"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fillRule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clipRule="evenodd"
          />
        </svg>
      </div>
    </div>
  );
});
