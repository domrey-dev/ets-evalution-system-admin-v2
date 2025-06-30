import { forwardRef, useEffect, useRef } from "react";

export default forwardRef(function TextAreaInput(
  { className = "", isFocused = false, children, ...props },
  ref
) {
  const input = ref ? ref : useRef();

  useEffect(() => {
    if (isFocused) {
      input.current.focus();
    }
  }, []);

  return (
    <textarea
      {...props}
      className={
        "border-gray-300 bg-white text-black focus:border-emerald-400 focus:ring-emerald-400 rounded-md shadow-sm " +
        className
      }
      ref={input}
    >
      {children}
    </textarea>
  );
});
