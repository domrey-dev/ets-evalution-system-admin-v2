import React from "react";

export default function EvaluationNav({ activeTab, setActiveTab }) {
  const navItems = [
    { id: "staff", label: "Staff Evaluation", khmerLabel: "ការវាយតម្លៃបុគ្គលិក" },
    { id: "self", label: "Self Evaluation", khmerLabel: "ការវាយតម្លៃខ្លួនឯង" },
    { id: "final", label: "Final Evaluation", khmerLabel: "ការវាយតម្លៃចុងក្រោយ" },
  ];

  return (
    <div className="mb-6 border-b border-gray-200">
      <div className="flex justify-center overflow-x-auto space-x-4">
        {navItems.map((item) => (
          <button
            key={item.id}
            onClick={() => setActiveTab(item.id)}
            className={`py-3 px-4 focus:outline-none transition-colors duration-200 whitespace-nowrap ${
              activeTab === item.id
                ? "border-b-2 border-emerald-500 text-emerald-600 font-medium"
                : "text-gray-600 hover:text-gray-800 hover:border-b-2 hover:border-gray-300"
            }`}
            aria-current={activeTab === item.id ? "page" : undefined}
          >
            <div className="text-sm font-medium text-center">
              <div className="mb-1">{item.khmerLabel}</div>
              <div className="text-xs">{item.label}</div>
            </div>
          </button>
        ))}
      </div>
    </div>
  );
}
