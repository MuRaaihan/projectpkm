// ── FileUpload Component ─────────────────────────────────────
"use client";

import { useRef, useState } from "react";
import { Paperclip, X, ImageIcon, FileText } from "lucide-react";

interface FileUploadProps {
  value: File | null;
  onChange: (file: File | null) => void;
}

function formatBytes(bytes: number): string {
  if (bytes < 1024) return `${bytes} B`;
  if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
  return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
}

export function FileUpload({ value, onChange }: FileUploadProps) {
  const inputRef = useRef<HTMLInputElement>(null);
  const [isDragging, setIsDragging] = useState(false);

  const handleFileChange = (files: FileList | null) => {
    if (files && files.length > 0) {
      onChange(files[0]);
    }
  };

  const handleDrop = (e: React.DragEvent) => {
    e.preventDefault();
    setIsDragging(false);
    handleFileChange(e.dataTransfer.files);
  };

  const getFileIcon = (file: File) => {
    if (file.type.startsWith("image/")) {
      return (
        <ImageIcon className="w-4 h-4 text-primary-500" aria-hidden="true" />
      );
    }
    return (
      <FileText
        className="w-4 h-4 text-slate-600 dark:text-slate-400"
        aria-hidden="true"
      />
    );
  };

  if (value) {
    return (
      <div className="flex items-center gap-3 p-3.5 bg-primary-50 dark:bg-primary-900/10 border border-primary-200 dark:border-primary-900/30 rounded-lg">
        <div className="w-8 h-8 bg-surface-card dark:bg-slate-800 rounded-md flex items-center justify-center border border-slate-200 dark:border-slate-700 shrink-0">
          {getFileIcon(value)}
        </div>
        <div className="flex-1 min-w-0">
          <p className="text-sm font-medium text-slate-700 dark:text-slate-100 truncate">
            {value.name}
          </p>
          <p className="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
            {formatBytes(value.size)}
          </p>
        </div>
        <button
          type="button"
          onClick={() => onChange(null)}
          className="w-7 h-7 flex items-center justify-center rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 text-slate-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors"
          aria-label="Hapus lampiran"
        >
          <X className="w-4 h-4" aria-hidden="true" />
        </button>
      </div>
    );
  }

  return (
    <div>
      <input
        ref={inputRef}
        type="file"
        accept="image/*,video/*,.pdf,.doc,.docx"
        className="sr-only"
        onChange={(e) => handleFileChange(e.target.files)}
        aria-label="Upload lampiran"
      />
      <button
        type="button"
        onClick={() => inputRef.current?.click()}
        onDragOver={(e) => {
          e.preventDefault();
          setIsDragging(true);
        }}
        onDragLeave={() => setIsDragging(false)}
        onDrop={handleDrop}
        className={[
          "w-full border-2 border-dashed rounded-lg p-5 flex flex-col items-center gap-2 transition-all duration-150 cursor-pointer",
          isDragging
            ? "border-primary-400 dark:border-primary-600 bg-primary-50 dark:bg-primary-900/10"
            : "border-slate-300 dark:border-slate-700 hover:border-primary-400 dark:hover:border-primary-600 hover:bg-primary-50/50 dark:hover:bg-primary-900/10 bg-surface-card dark:bg-slate-800/30",
        ].join(" ")}
      >
        <div className="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center">
          <Paperclip
            className="w-5 h-5 text-slate-600 dark:text-slate-400"
            aria-hidden="true"
          />
        </div>
        <div className="text-center">
          <p className="text-sm font-medium text-slate-700 dark:text-slate-200">
            Tambahkan bukti
          </p>
          <p className="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
            Foto, video, atau file lainnya
          </p>
        </div>
      </button>
    </div>
  );
}
