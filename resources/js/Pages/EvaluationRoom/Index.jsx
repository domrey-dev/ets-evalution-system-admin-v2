import {useState, useEffect, useCallback} from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Head, Link, usePage, router} from "@inertiajs/react";
import EvaluationModel from "@/Pages/EvaluationRoom/EvaluationModel.jsx";
import EvaluationNav from "./EvaluationNav.jsx";
import EvaluationForm from "./EvaluationForm.jsx";

const EVALUATION_TYPES = {
    STAFF: 'staff',
    SELF: 'self',
    FINAL: 'final'
};

const transformEvaluationsToFormData = (evaluation) => {
    if (!evaluation?.child_evaluations) return {};

    return evaluation.child_evaluations.reduce((acc, item) => {
        acc[item.evaluation_id] = {
            feedback: item.feedback || '',
            rating: item.rating || ''
        };
        return acc;
    }, {});
};

export default function EvaluationRoom({
                                           auth,
                                           success,
                                           criteria: criteriaData,
                                           model_data = {},
                                           final = {},
                                           queryParams = {}
                                       }) {
    const {flash} = usePage().props;
    const criteria = criteriaData?.data || [];

    // Permission checks
    const canAccessRoomStaff = auth.can['evaluation-room-staff'];
    const canAccessRoomSelf = auth.can['evaluation-room-self'];
    const canAccessRoomFinal = auth.can['evaluation-room-final'];
    const canSubmitRoom = auth.can['evaluation-room-submit'];

    // State management
    const [activeTab, setActiveTab] = useState(
        canAccessRoomSelf ? EVALUATION_TYPES.SELF :
            canAccessRoomStaff ? EVALUATION_TYPES.STAFF :
                canAccessRoomFinal ? EVALUATION_TYPES.FINAL : EVALUATION_TYPES.SELF
    );

    const [evaluations, setEvaluations] = useState({
        self: null,
        staff: null,
        final: null
    });

    const [evaluationData, setEvaluationData] = useState({});
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [submitError, setSubmitError] = useState(null);
    const [validationErrors, setValidationErrors] = useState({});

    useEffect(() => {
        if (final?.self) {
            setEvaluations(prev => ({...prev, self: final.self}));
        }
        if (final?.staff) {
            setEvaluations(prev => ({...prev, staff: final.staff}));
        }
    }, [final]);

    useEffect(() => {
        if (!criteria.length) return;

        const initializeEmptyForm = () => {
            return criteria.reduce((acc, item) => {
                acc[item.id] = {feedback: '', rating: ''};
                return acc;
            }, {});
        };

        if (!evaluations.self) {
            setEvaluations(prev => ({
                ...prev,
                self: {
                    evaluation_type: EVALUATION_TYPES.SELF,
                    child_evaluations: criteria.map(item => ({
                        evaluation_id: item.id,
                        feedback: '',
                        rating: null
                    }))
                }
            }));
        }

        if (!evaluations.staff) {
            setEvaluations(prev => ({
                ...prev,
                staff: {
                    evaluation_type: EVALUATION_TYPES.STAFF,
                    child_evaluations: criteria.map(item => ({
                        evaluation_id: item.id,
                        feedback: '',
                        rating: null
                    }))
                }
            }));
        }
    }, [criteria]);

    // Handle data changes from EvaluationModel
    const handleDataChange = (newData) => {
        setEvaluationData(prev => ({ ...prev, ...newData }));
    };
    const handleStaffChange = (updatedItems) => {
        setEvaluations(prev => {
            // Safely get current staff evaluation or initialize
            const currentStaff = prev.staff || {
                evaluation_type: EVALUATION_TYPES.STAFF,
                child_evaluations: criteria.map(item => ({
                    evaluation_id: item.id,
                    feedback: '',
                    rating: null
                }))
            };

            // Safely get existing evaluations
            const existingEvaluations = currentStaff.child_evaluations || [];

            // Convert updates to array
            const updatesArray = Object.values(updatedItems);

            // Create a map of existing evaluations
            const evaluationsMap = new Map(
                existingEvaluations.map(item => [item.evaluation_id, item])
            );

            // Apply updates
            updatesArray.forEach(update => {
                evaluationsMap.set(update.evaluation_id, {
                    ...(evaluationsMap.get(update.evaluation_id) || {
                        evaluation_id: update.evaluation_id,
                        feedback: '',
                        rating: null
                    }),
                    ...update
                });
            });

            return {
                ...prev,
                staff: {
                    ...currentStaff,
                    child_evaluations: Array.from(evaluationsMap.values())
                }
            };
        });
    };

    const handleSelfChange = (updatedItems) => {
        setEvaluations(prev => {
            // Safely get current self evaluation or initialize
            const currentSelf = prev.self || {
                evaluation_type: EVALUATION_TYPES.SELF,
                child_evaluations: criteria.map(item => ({
                    evaluation_id: item.id,
                    feedback: '',
                    rating: null
                }))
            };

            // Safely get existing evaluations
            const existingEvaluations = currentSelf.child_evaluations || [];

            // Convert updates to array
            const updatesArray = Object.values(updatedItems);

            // Create a map of existing evaluations
            const evaluationsMap = new Map(
                existingEvaluations.map(item => [item.evaluation_id, item])
            );

            // Apply updates
            updatesArray.forEach(update => {
                evaluationsMap.set(update.evaluation_id, {
                    ...(evaluationsMap.get(update.evaluation_id) || {
                        evaluation_id: update.evaluation_id,
                        feedback: '',
                        rating: null
                    }),
                    ...update
                });
            });

            return {
                ...prev,
                self: {
                    ...currentSelf,
                    child_evaluations: Array.from(evaluationsMap.values())
                }
            };
        });
    };

    const handleFinalChange = (updatedItems) => {
        setEvaluations(prev => {
            // Safely get current self evaluation or initialize
            const currentFinal = prev.final || {
                evaluation_type: EVALUATION_TYPES.FINAL,
                child_evaluations: criteria.map(item => ({
                    evaluation_id: item.id,
                    feedback: '',
                    rating: null
                }))
            };

            // Safely get existing evaluations
            const existingEvaluations = currentFinal.child_evaluations || [];

            // Convert updates to array
            const updatesArray = Object.values(updatedItems);

            // Create a map of existing evaluations
            const evaluationsMap = new Map(
                existingEvaluations.map(item => [item.evaluation_id, item])
            );

            // Apply updates
            updatesArray.forEach(update => {
                evaluationsMap.set(update.evaluation_id, {
                    ...(evaluationsMap.get(update.evaluation_id) || {
                        evaluation_id: update.evaluation_id,
                        feedback: '',
                        rating: null
                    }),
                    ...update
                });
            });

            return {
                ...prev,
                final: {
                    ...currentFinal,
                    child_evaluations: Array.from(evaluationsMap.values())
                }
            };
        });
    };


    // Form submission
    const handleSubmit = async () => {
        setIsSubmitting(true);

        try {
            const activeEvaluation = evaluations[activeTab];

            if (!activeEvaluation?.child_evaluations?.length) {
                throw new Error('No evaluation data to submit');
            }

            const payload = {
                model_data: evaluationData,
                evaluation_type: activeTab,
                evaluation: {
                    ...activeEvaluation,
                    child_evaluations: activeEvaluation.child_evaluations
                },
                criteria: criteria
            };

            console.log('Submission payload:', payload);
            await router.post(route("evaluations_room.store"), payload);

        } catch (error) {
            setSubmitError(error.message);
        } finally {
            setIsSubmitting(false);
        }
    };

    // Search handler with debounce
    const handleSearch = useCallback(async (employeeId) => {
        try {
            await router.get(route("evaluations_room.index"), {employeeId}, {
                preserveState: true,
                replace: true,
                onSuccess: (page) => {
                    setEvaluationData(page.props.model_data || {});
                },
                onError: () => {
                    setEvaluationData(prev => ({
                        ...prev,
                        employeeName: '',
                        jobTitle: '',
                        department: ''
                    }));
                }
            });
        } catch (error) {
            console.error("Search failed:", error);
        }
    }, []);

    // Determine if we should show tabs
    const showTabs = [canAccessRoomStaff, canAccessRoomSelf, canAccessRoomFinal].filter(Boolean).length > 1;

    // Get active tab title
    const getActiveTabTitle = () => {
        switch (activeTab) {
            case EVALUATION_TYPES.STAFF:
                return "Staff Evaluation Room";
            case EVALUATION_TYPES.SELF:
                return "Self Evaluation Room";
            case EVALUATION_TYPES.FINAL:
                return "Final Evaluation Room";
            default:
                return "Evaluation Room";
        }
    };

    // Get active tab description
    const getActiveTabDescription = () => {
        switch (activeTab) {
            case EVALUATION_TYPES.STAFF:
                return "Department Head Evaluation";
            case EVALUATION_TYPES.SELF:
                return "Employee Self Evaluation";
            case EVALUATION_TYPES.FINAL:
                return "Final Review Evaluation";
            default:
                return "";
        }
    };

    return (
        <AuthenticatedLayout
            auth={auth}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Evaluation Room
                    </h2>
                    {canSubmitRoom && (
                        <Link
                            href={route("evaluations_room.create")}
                            className="bg-emerald-500 py-2 px-4 text-white rounded shadow hover:bg-emerald-600 transition"
                        >
                            Submit Evaluation
                        </Link>
                    )}
                </div>
            }
        >
            <Head title="Evaluation Room"/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {/* Flash messages */}
                            {flash?.message && (
                                <div className="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                    {flash.message}
                                </div>
                            )}

                            {/* Navigation tabs */}
                            {showTabs && (
                                <EvaluationNav
                                    activeTab={activeTab}
                                    setActiveTab={setActiveTab}
                                    canAccessStaff={canAccessRoomStaff}
                                    canAccessSelf={canAccessRoomSelf}
                                    canAccessFinal={canAccessRoomFinal}
                                />
                            )}

                            {/* Tab header */}
                            <div className="mb-6 mt-4 text-center">
                                <h1 className="text-2xl font-bold mb-2">{getActiveTabTitle()}</h1>
                                <p className="text-gray-600">{getActiveTabDescription()}</p>
                            </div>

                            {/* Evaluation model selector */}
                            <EvaluationModel
                                onChange={handleDataChange}
                                initialData={{...evaluationData, ...model_data}}
                                onSearch={handleSearch}
                            />

                            {/* Error message */}
                            {submitError && (
                                <div className="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                    {submitError}
                                </div>
                            )}

                            {/* Staff evaluation form */}
                            {activeTab === EVALUATION_TYPES.STAFF && canAccessRoomStaff && evaluations.staff && (
                                <div className="mt-6">
                                    <h2 className="text-xl font-semibold mb-4">Staff Evaluation</h2>
                                    <EvaluationForm
                                        evaluationType={EVALUATION_TYPES.STAFF}
                                        onChange={handleStaffChange}
                                        data={transformEvaluationsToFormData(evaluations.staff)}
                                        criteria={criteria}
                                        errors={validationErrors.staff}
                                        readOnly={!canSubmitRoom}
                                    />
                                </div>
                            )}

                            {/* Self evaluation form */}
                            {activeTab === EVALUATION_TYPES.SELF && canAccessRoomSelf && evaluations.self && (
                                <div className="mt-6">
                                    <h2 className="text-xl font-semibold mb-4">Self Evaluation</h2>
                                    <EvaluationForm
                                        evaluationType={EVALUATION_TYPES.SELF}
                                        onChange={handleSelfChange}
                                        data={transformEvaluationsToFormData(evaluations.self)}
                                        criteria={criteria}
                                        errors={validationErrors.self}
                                        readOnly={!canSubmitRoom}
                                    />
                                </div>
                            )}

                            {/* Final evaluation form */}
                            {activeTab === EVALUATION_TYPES.FINAL && canAccessRoomFinal && (
                                <div className="mt-6">
                                    <h2 className="text-xl font-semibold mb-4">Final Evaluation</h2>
                                    <div className="flex gap-6 mb-6">
                                        {canAccessRoomStaff && evaluations.staff && (
                                            <div className="w-1/2 border rounded p-4 bg-gray-50">
                                                <h3 className="font-bold mb-2">Staff Evaluation</h3>
                                                <EvaluationForm
                                                    evaluationType={EVALUATION_TYPES.STAFF}
                                                    data={transformEvaluationsToFormData(evaluations.staff)}
                                                    criteria={criteria}
                                                    readOnly
                                                />
                                                <button
                                                    className="mt-2 bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600 transition"
                                                    onClick={() => setEvaluations(prev => ({
                                                        ...prev,
                                                        final: prev.staff
                                                    }))}
                                                    type="button"
                                                >
                                                    Choose this
                                                </button>
                                            </div>
                                        )}
                                        {canAccessRoomSelf && evaluations.self && (
                                            <div className="w-1/2 border rounded p-4 bg-gray-50">
                                                <h3 className="font-bold mb-2">Self Evaluation</h3>
                                                <EvaluationForm
                                                    evaluationType={EVALUATION_TYPES.SELF}
                                                    data={transformEvaluationsToFormData(evaluations.self)}
                                                    criteria={criteria}
                                                    readOnly
                                                />
                                                <button
                                                    className="mt-2 bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600 transition"
                                                    onClick={() => setEvaluations(prev => ({
                                                        ...prev,
                                                        final: prev.self
                                                    }))}
                                                    type="button"
                                                >
                                                    Choose this
                                                </button>
                                            </div>
                                        )}
                                    </div>
                                    <EvaluationForm
                                        evaluationType={EVALUATION_TYPES.FINAL}
                                        onChange={handleFinalChange}
                                        data={transformEvaluationsToFormData(evaluations.final)}
                                        criteria={criteria}
                                        errors={validationErrors.final}
                                        readOnly={!canSubmitRoom}
                                    />
                                </div>
                            )}

                            {/* Submit button */}
                            {canSubmitRoom && (
                                <div className="mt-6 flex justify-end">
                                    <button
                                        type="button"
                                        className="bg-emerald-500 py-2 px-6 text-white rounded shadow hover:bg-emerald-600 transition disabled:opacity-50"
                                        onClick={handleSubmit}
                                        disabled={isSubmitting}
                                    >
                                        {isSubmitting ? 'Submitting...' : 'Submit Evaluation'}
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}