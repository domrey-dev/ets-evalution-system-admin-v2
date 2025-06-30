import { useState, useEffect } from 'react';
import { useDebounce } from '@/hooks/useDebounce';

export default function EvaluationModel({ onChange = () => {}, initialData = {}, onSearch }) {
  const [searchId, setSearchId] = useState(initialData.searchId || '');
  const debouncedSearchId = useDebounce(searchId, 500);

  useEffect(() => {
    setSearchId(initialData.searchId || '');
  }, [initialData.searchId]);

  useEffect(() => {
    if (debouncedSearchId && debouncedSearchId !== initialData.searchId) {
      onSearch(debouncedSearchId);
    }
  }, [debouncedSearchId, onSearch, initialData.searchId]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    if (name === 'searchId') {
      setSearchId(value);
    } else {
      onChange({ [name]: value });
    }
  };

  const handleKeyDown = (e) => {
    if (e.key === 'Enter' && searchId) {
      onSearch(searchId);
    }
  };

  return (
      <div className="max-w-6xl mx-auto p-6 bg-white rounded shadow">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Search User ID
            </label>
            <input
                type="text"
                name="searchId"
                value={searchId}
                placeholder="Search by ID (press Enter to search immediately)"
                className="w-full border-b border-gray-300 p-2 focus:outline-none"
                onChange={handleInputChange}
                onKeyDown={handleKeyDown}
            />
            {searchId && (
                <p className="text-xs text-gray-500 mt-1">
                  Searching for ID: {searchId}
                </p>
            )}
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Monthly Performance
            </label>
            <input
                type="text"
                name="monthlyPerformance"
                placeholder="Staff Performance"
                className="w-full border-b border-gray-300 p-2 focus:outline-none"
                onChange={handleInputChange}
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Employee Name
            </label>
            <input
                type="text"
                name="employeeName"
                value={initialData.employeeName || ''}
                className="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readOnly
                disabled
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Date of Evaluation
            </label>
            <input
                type="date"
                name="evaluationDate"
                className="w-full border-b border-gray-300 p-2 focus:outline-none"
                onChange={handleInputChange}
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Job Title
            </label>
            <input
                type="text"
                name="jobTitle"
                value={initialData.jobTitle || ''}
                className="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readOnly
                disabled
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Department
            </label>
            <input
                type="text"
                name="department"
                value={initialData.department || ''}
                className="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readOnly
                disabled
            />
          </div>
        </div>
      </div>
  );
}