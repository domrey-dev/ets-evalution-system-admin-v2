import { useState, useEffect } from "react";

export default function EvaluationForm({
                                         evaluationType,
                                         onChange,
                                         data = {},
                                         criteria,
                                         readOnly = false,
                                         errors = {}
                                       }) {
    // Initialize formData as a controlled component
    const [formData, setFormData] = useState({});

    // Only initialize formData once when criteria loads
    useEffect(() => {
        if (criteria.length && Object.keys(formData).length === 0) {
            const initialData = {};
            criteria.forEach(item => {
                initialData[item.id] = {
                    feedback: data[item.id]?.feedback || '',
                    rating: data[item.id]?.rating || ''
                };
            });
            setFormData(initialData);
        }
    }, [criteria]); // Only depend on criteria

    // In EvaluationForm.jsx
    const handleInputChange = (criteriaId, field, value) => {
        const updated = {
            ...formData,
            [criteriaId]: {
                ...formData[criteriaId],
                [field]: value,
                evaluation_id: criteriaId
            }
        };

        setFormData(updated);

        if (onChange) {
            onChange({
                [criteriaId]: updated[criteriaId]
            });
        }
    };

    return (
      <div className="mt-6">
        <div className="flex justify-between mb-4">
          <div className="text-sm font-medium">
            <div>តម្លៃសមិទ្ធផល: អ្នកគ្រប់គ្រងផ្ទាល់ផ្តល់យោបល់ខាងក្រោម</div>
            <div className="text-gray-600">Section 2: Evaluation points in practice Comments and feedback by Supervisor/Manager</div>
          </div>
          <div className="text-sm font-medium text-right">
            <div>តម្លៃលេខ ១-៥</div>
            <div className="text-gray-600">Performance Rating 1-5</div>
          </div>
        </div>
          {criteria.map((item) => (
              <div key={item.id} className="mb-8">
                  <div className="mb-2 font-medium">{item.title}</div>
                  <div className="text-sm mb-1">យោបល់/Comments & feedback:</div>
                  <div className="flex gap-4">
                      <div className="flex-grow">
              <textarea
                  className={`w-full border border-gray-300 rounded p-2 ${
                      readOnly ? 'bg-gray-100 cursor-not-allowed' : ''
                  }`}
                  rows="2"
                  placeholder={readOnly ? "" : "Write feedback here..."}
                  value={formData[item.id]?.feedback || ''}
                  onChange={(e) => handleInputChange(item.id, 'feedback', e.target.value)}
                  readOnly={readOnly}
              />
                      </div>
                      <div className="w-32">
                          <select
                              className={`w-full border border-gray-300 rounded p-2 text-sm h-10 ${
                                  readOnly ? 'bg-gray-100 cursor-not-allowed' : ''
                              }`}
                              value={formData[item.id]?.rating || ''}
                              onChange={(e) => handleInputChange(item.id, 'rating', e.target.value)}
                              disabled={readOnly}
                          >
                              <option value="">Select</option>
                              {[1, 2, 3, 4, 5].map((num) => (
                                  <option key={num} value={num}>
                                      {num}
                                  </option>
                              ))}
                          </select>
                      </div>
                  </div>
              </div>
          ))}
        </div>
    );
}