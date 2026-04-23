#!/bin/bash
set -euo pipefail

VERSION="${1:-0.0.2}"
TOPDIR="${HOME}/rpmbuild"
SPECFILE="packaging/app-cpu-monitor.spec"
TARBALL="${TOPDIR}/SOURCES/cpu-monitor-${VERSION}.tar.gz"

mkdir -p "${TOPDIR}/BUILD" \
         "${TOPDIR}/BUILDROOT" \
         "${TOPDIR}/RPMS" \
         "${TOPDIR}/SOURCES" \
         "${TOPDIR}/SPECS" \
         "${TOPDIR}/SRPMS"

git archive \
  --format=tar.gz \
  --prefix="cpu-monitor-${VERSION}/" \
  -o "${TARBALL}" \
  HEAD

cp "${SPECFILE}" "${TOPDIR}/SPECS/"

rpmbuild -ba "${TOPDIR}/SPECS/app-cpu-monitor.spec" \
  --define "_topdir ${TOPDIR}"
