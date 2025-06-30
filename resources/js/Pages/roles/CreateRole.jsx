import { Link, useForm, usePage } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function CreateRole() {
    const { permissions = [] } = usePage().props;

    const { data, setData, post, processing, errors } = useForm({
        name: "",
        permissions: [],
    });

    const handleCheckboxToggle = (permission) => {
        setData(
            "permissions",
            data.permissions.includes(permission)
                ? data.permissions.filter((p) => p !== permission)
                : [...data.permissions, permission]
        );
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("roles.store"));
    };

    return (
        <AuthenticatedLayout>
            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="bg-white shadow rounded-lg p-6">
                        <div className="flex items-center justify-between mb-6">
                            <h1 className="text-2xl font-semibold text-gray-800">
                                Create New Role
                            </h1>
                            <Link
                                href={route("roles.index")}
                                className="text-sm text-indigo-600 hover:underline"
                            >
                                Back
                            </Link>
                        </div>

                        <form onSubmit={handleSubmit}>
                            {/* Role Name */}
                            <div className="mb-5">
                                <label
                                    htmlFor="name"
                                    className="block text-gray-700 font-medium mb-1"
                                >
                                    Name
                                </label>
                                <input
                                    id="name"
                                    placeholder="Enter role name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                    className="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-600 mt-1">
                                        {errors.name}
                                    </p>
                                )}
                            </div>

                            {/* Permissions */}
                            <div className="mb-6">
                                <label className="block text-gray-700 font-medium mb-2">
                                    Permissions
                                </label>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    {permissions.map((permission) => (
                                        <label
                                            key={permission}
                                            htmlFor={`permission-${permission}`}
                                            className="inline-flex items-center gap-2 text-gray-700"
                                        >
                                            <input
                                                type="checkbox"
                                                id={`permission-${permission}`}
                                                className="text-indigo-600 border-gray-300 rounded"
                                                checked={data.permissions.includes(
                                                    permission
                                                )}
                                                onChange={() =>
                                                    handleCheckboxToggle(
                                                        permission
                                                    )
                                                }
                                            />
                                            {permission}
                                        </label>
                                    ))}
                                </div>
                                {errors.permissions && (
                                    <p className="text-sm text-red-600 mt-1">
                                        {errors.permissions}
                                    </p>
                                )}
                            </div>

                            {/* Submit Button */}
                            <div className="flex justify-end">
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300 disabled:opacity-50 transition"
                                >
                                    {processing ? "Creating..." : "Create"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
